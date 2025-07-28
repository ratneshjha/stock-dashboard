from alpha_vantage.timeseries import TimeSeries
import pandas as pd
import numpy as np
import time

# --- IMPORTANT ---
# Replace 'YOUR_API_KEY' with your actual Alpha Vantage API key.
# You can get a free API key from https://www.alphavantage.co/support/#api-key
API_KEY = 'YOUR_API_KEY'


def get_stock_data(ticker, output_size='full', timeout=30):
    """Fetches historical stock data for a single ticker from Alpha Vantage."""
    try:
        ts = TimeSeries(key=API_KEY, output_format='pandas', treat_info_as_error=True)
        data, meta_data = ts.get_daily(symbol=ticker, outputsize=output_size)
        return data['4. close']
    except Exception as e:
        print(f"Error fetching stock data for {ticker}: {e}")
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

def analyze_portfolio(tickers):
    """
    Analyzes a portfolio of stocks and provides recommendations.
    """
    if not tickers:
        return None

    all_data = {}
    for ticker in tickers:
        print(f"Fetching data for {ticker}...")
        data = get_stock_data(ticker)
        if data is not None:
            all_data[ticker] = data
        time.sleep(12)  # Alpha Vantage free tier allows 5 calls per minute

    if not all_data:
        return None

    full_data = pd.DataFrame(all_data)

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
    ranked_stocks = combined_score.sort_values(ascending=False)

    recommendations = []
    for ticker, score in ranked_stocks.items():
        if score > 0:
            recommendations.append(f"KEEP {ticker} (Score: {score:.2f})")
        else:
            recommendations.append(f"SELL {ticker} (Score: {score:.2f})")

    return recommendations

if __name__ == "__main__":
    # Get tickers from user
    tickers_str = input("Enter a comma-separated list of stock tickers: ")
    tickers = [ticker.strip() for ticker in tickers_str.split(',')]
    recommendations = analyze_portfolio(tickers)
    if recommendations is not None:
        print("\nPortfolio Analysis:")
        for recommendation in recommendations:
            print(recommendation)
