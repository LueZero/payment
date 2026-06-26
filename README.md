# Zero Payment

Zero Payment is a lightweight PHP payment integration package for Taiwan payment providers. It currently supports:

- [ECPay](https://www.ecpay.com.tw/)
- [LINE Pay](https://pay.line.me/portal/tw/main)

The package provides a small unified entry point, `Zero\PaymentClient`, while keeping each provider's signing and request flow inside its own payment implementation.

## Requirements

- PHP 7.0 or higher
- PHP cURL extension
- Composer

Development tests currently use PHPUnit 10, so running the test suite requires PHP 8.1 or higher.

## Installation

```bash
composer install
```

## Configuration

Copy the example configuration before using the package:

```bash
cp src/config.example.php src/config.php
```

`src/config.php` is ignored by Git and must not be committed. Replace the sample sandbox credentials with your own provider credentials before running real transactions.

Review these values before going live:

- ECPay: `MerchantID`, `HashKey`, `HashIV`, `CreditCheckCode`
- LINE Pay: `ChannelId`, `ChannelSecret`
- Provider base URLs for sandbox or production
- Return, confirm, and cancel URLs reachable by the provider

## Usage

Load Composer autoload and create a provider payment instance:

```php
require './vendor/autoload.php';

use Zero\PaymentClient;

$paymentClient = new PaymentClient('ec');
$payment = $paymentClient->createPayment();
```

Provider keys:

- `ec`: ECPay
- `line`: LINE Pay

See [example.php](example.php) for end-to-end examples covering checkout, order search, detail search, confirmation, and refund flows. All execution lines are commented out by default. Uncomment one flow at a time when testing.

### ECPay Checkout

```php
$paymentClient = new PaymentClient('ec');
$payment = $paymentClient->createPayment();

$requests = [
    'MerchantID' => '2000132',
    'MerchantTradeNo' => date('YmdHis'),
    'MerchantTradeDate' => date('Y/m/d H:i:s'),
    'PaymentType' => 'aio',
    'TotalAmount' => 500,
    'TradeDesc' => urlencode('Test transaction'),
    'ItemName' => 'Demo product 500 TWD',
    'ReturnURL' => 'https://your.web.site/ecpay/return.php',
    'ChoosePayment' => 'Credit',
    'EncryptType' => 1,
];

echo $payment->setRequestParameter($requests)->checkout();
```

### ECPay Order Search

```php
$requests = [
    'MerchantID' => '2000132',
    'MerchantTradeNo' => '220220811214215',
    'TimeStamp' => time(),
    'PlatformID' => 2000132,
];

echo $payment->setRequestParameter($requests)->search();
```

### ECPay Refund

```php
$requests = [
    'MerchantID' => '2000132',
    'MerchantTradeNo' => 'zero20220821101552',
    'TradeNo' => '2208211615567910',
    'Action' => 'R',
    'TotalAmount' => 100,
];

echo $payment->setRequestParameter($requests)->refund();
```

### LINE Pay Checkout

```php
$paymentClient = new PaymentClient('line');
$payment = $paymentClient->createPayment();
$transactionId = date('YmdHis');

$requests = [
    'amount' => 100,
    'currency' => 'TWD',
    'orderId' => $transactionId,
    'packages' => [
        [
            'id' => 1,
            'amount' => 100,
            'name' => 'Test',
            'products' => [
                [
                    'name' => 'Demo product',
                    'imageUrl' => 'https://example.com/product.jpg',
                    'quantity' => 1,
                    'price' => 100,
                ],
            ],
        ],
    ],
    'redirectUrls' => [
        'confirmUrl' => 'https://your.web.site/line-pay/confirm.php',
        'cancelUrl' => 'https://your.web.site/line-pay/cancel.php',
    ],
];

echo $payment->setRequestParameter($requests)->checkout();
```

### LINE Pay Confirm

```php
$requests = [
    'amount' => 100,
    'currency' => 'TWD',
];

echo $payment->setRequestParameter($requests)->confirm('2022082400725100210');
```

### LINE Pay Order Search

```php
$requests = [
    'orderId' => '20220821103746',
];

echo $payment->setRequestParameter($requests)->search();
```

### LINE Pay Refund

```php
$requests = [
    'refundAmount' => 100,
];

echo $payment->setRequestParameter($requests)->refund('2022082400725100210');
```

## Project Structure

- `src/PaymentClient.php`: Creates provider payment instances.
- `src/Payments`: Provider-specific payment implementations, signing, checkout, search, and refund logic.
- `src/Http.php`: cURL request handling and HTML form generation.
- `src/Requests/Parameters`: Request parameter objects for provider operations.
- `src/config.example.php`: Sandbox configuration template.
- `example.php`: Manual usage examples.
- `tests`: PHPUnit tests.

## Testing

```bash
./vendor/bin/phpunit tests
```

On Windows PowerShell:

```powershell
.\vendor\bin\phpunit tests
```

The test suite creates a temporary `src/config.php` from `src/config.example.php` when no local config file exists, then removes it after the run.

## Security and Production Notes

- Never commit production credentials, merchant IDs, webhook URLs, or `.env` files.
- Keep `src/config.php` ignored and commit only `src/config.example.php`.
- Always verify provider callbacks, transaction state, and reconciliation in your application layer.
- Test checkout, search, refund, and callback flows in the provider sandbox before using production credentials.
- Payment provider APIs may change. Re-check the official ECPay and LINE Pay documentation before releasing provider-related changes.
- This package sends requests and generates signatures. It does not implement order state management, inventory locking, webhook verification, or accounting reconciliation.

## Open Source Maintenance

Recommended project policy before publishing:

- This project is released under the MIT License. See [LICENSE](LICENSE).
- Keep public APIs backward compatible where possible, especially `PaymentClient` and `setRequestParameter()`.
- Add or update examples and tests when adding provider operations.
- Use issue labels such as `bug`, `provider-change`, `feature`, `docs`, and `security`.
- Pull requests that change provider behavior should include the relevant official documentation link or sandbox verification notes.

## License

MIT License. See [LICENSE](LICENSE).
