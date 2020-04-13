## [v0.0.8]
> Dec 11, 2019

- Addition of the `_getChamada` method
- Removing duplicate code

## [v0.0.7]

> Dec 10, 2019

- Added error table
- Changed private methods with the prefix `_method`
- Use of Codacy for code improvement

## [v0.0.62]
> Dec 09, 2019

- Added Demo
- Separation of the develop version (Development version) and master version (Last functional version)
- Fixed bug not showing ID
- Added error checking when the session cannot be generated

## [v0.0.61]
> Dec 08, 2019

- Improved documentation
- Added INSTALING.md
- Correction of email and insert bugs in the database
- Addition of item in payment method

## [v0.0.6]
> Dec 08, 2019

- Payment library creation
- Changes in library functions to prevent errors
- Addition of a single method for the payment controller
- Add develop only with the necessary codes for integration

## [v0.0.5]
> Dec 07, 2019

- Addition of extension = openssl for working with sending e-mail
- Changed the PagSeguro URL configuration data to `Config / PagSeguro.php`
- Removed `api.mode` parameter from .env
- Changed new `Config \ PagSeguro` to` config ('PagSeguro') `

## [v0.0.4]
> Dec 06, 2019

- Correction of version [v0.0.3] to make the verification only on the necessary Controller.
- Changing the payment helper to clear code
- Relocation of the pagseguro session to a new controller
- Perfecting the layout
- Place the boleto in the function of notifying by email
- Wait for the Session request to release the payment button

## [v0.0.3]
> Dec 05, 2019

- Changed the sending of e-mail to perform only when the environment variable is `true`

## [v0.0.2]
> Dec 04, 2019

- Addition of the Status page before starting the code so that the checks of the insurance can be carried out.
- Changed `public $ threshold = 9;` in `app / Config / Logger` to display all logs
- Added transaction log
- Added functionality for using or not sending `default: false` email
- Resolved issue # 4 of sending email
- REMOVED :: Transaction search by ID
- Added in routes `$ routes-> get ('/ (: num)', 'Home :: list / $ 1');`

## [v0.0.1]
> Dec 03, 2019

- Finalization of the card payment method
- Bug fixes
- Addition of payment pre-loader
- Improved code organization
