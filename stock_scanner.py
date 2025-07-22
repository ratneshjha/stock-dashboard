import yfinance as yf
import pandas as pd
import numpy as np
import time

def get_sp500_tickers():
    """Fetches the list of S&P 500 tickers from Wikipedia."""
    try:
        payload = pd.read_html('https://en.wikipedia.org/wiki/List_of_S%26P_500_companies')
        first_table = payload[0]
        tickers = first_table['Symbol'].values.tolist()
        # Replace tickers with dots with dashes
        tickers = [ticker.replace('.', '-') for ticker in tickers]
        return tickers
    except Exception as e:
        print(f"Error fetching S&P 500 tickers: {e}")
        return None

def get_stock_data(tickers, period="1y", interval="1d"):
    """Fetches historical stock data for a list of tickers."""
    try:
        data = yf.download(tickers, period=period, interval=interval)
        return data['Adj Close']
    except Exception as e:
        print(f"Error fetching stock data: {e}")
        return None

def calculate_momentum(data):
    """Calculates the momentum for each stock."""
    # Calculate the 12-month log return
    momentum = np.log(data) - np.log(data.shift(12))
    return momentum.iloc[-1]

def calculate_volatility(data):
    """Calculates the annualized volatility for each stock."""
    log_returns = np.log(data / data.shift(1))
    return log_returns.rolling(window=252).std() * np.sqrt(252)

def get_strongest_stocks(top_n=10):
    """Identifies the top N strongest stocks based on momentum and volatility."""
    tickers = get_sp500_tickers()
    if not tickers:
        return None

    # Fetch data in smaller chunks to avoid issues
    chunk_size = 100
    all_data = []
    for i in range(0, len(tickers), chunk_size):
        chunk = tickers[i:i + chunk_size]
        data = get_stock_data(chunk)
        if data is not None:
            all_data.append(data)
        time.sleep(1)  # Add a 1-second delay between chunks

    if not all_data:
        return None

    full_data = pd.concat(all_data, axis=1)

    # Drop columns with all NaN values
    full_data = full_data.dropna(axis=1, how='all')

    if full_data.empty:
        print("No data available to calculate momentum and volatility.")
        return None

    momentum = calculate_momentum(full_data)
    volatility = calculate_volatility(full_data).iloc[-1]

    # Combine momentum and volatility
    combined_score = momentum / volatility

    # Sort stocks by combined score
    strongest_stocks = combined_score.sort_values(ascending=False)

    return strongest_stocks.head(top_n)

if __name__ == "__main__":
    top_10_stocks = get_strongest_stocks()
    if top_10_stocks is not None:
        print("Top 10 Strongest Stocks to Invest In:")
        print(top_10_stocks)
