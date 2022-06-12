# crypto-exchange-api

## Setup instructions

1. Clone repository
2. Go to project directory
3. Get API key for data provider https://www.coinapi.io/ and put in .env
5. Execute command `make start`
6. Execute `make shell` in order to go to the fpm container
7. Execute `cron` to start cron job


## API description

Currency exchange rate endpoint:

``http://localhost/exchangerate/{base}/{quote}/?time_start={time_start}&time_end={time_end}``

- base - base currency
- quote - quote currency
- time_start - starting time from which rates would be retrieved 
- time_end - time till rates would be retrieved

## Available currency pairs

| Base | Quoute |
|------|--------|
| BTC  | EUR    |
| BTC  | USD    |
| BTC  | ETH    |
| ETH  | EUR    |
| ETH  | USD    |