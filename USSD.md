[MENU] FARMER REGISTRATION MENU
    [RECORD] FULL NAMES
    [RECORD] NATIONAL IDENTIFICATION NUMBER
    [RECORD] YEAR OF BIRTH
    [DECISION] GENDER
        [I] MALE
        [II] FEMALE
    [RECORD] COUNTY NAME / COUNTY CODE
    [RECORD] NEAREST TOWN
    [RECORD] VILLAGE NAME
    [RECORD] LANDMARK SITE
    [RECORD] LAND SIZE ACREAGE
    [RECORD] ENUMERATOR CODE
    [DECISION] ORGANISATION CODE
        [I] CONTINUE -> [ACTION] send post request data to register farmers api
        [II] BACK -> [MENU] INITIALIZATION MENU
        [I2] EXIT -> [MENU] SESSION TERMINATION

php artisan ussd:state Initialize
php artisan ussd:state Terminate

php artisan ussd:state Account/Create/FullNames
php artisan ussd:state Account/Create/NationalIdentificationNumber
php artisan ussd:state Account/Create/YearOFBirth
php artisan ussd:state Account/Create/Gender
php artisan ussd:state Account/Create/County
php artisan ussd:state Account/Create/Town
php artisan ussd:state Account/Create/Village
php artisan ussd:state Account/Create/Landmark
php artisan ussd:state Account/Create/Acreage
php artisan ussd:state Account/Create/Enumerator
php artisan ussd:state Account/Create/Organization
php artisan ussd:state Account/Create/Confirmation
php artisan ussd:action Account/Create

php artisan ussd:state Account/Update/NationalIdentificationNumber
php artisan ussd:state Account/Update/Confirmation
php artisan ussd:action Account/Update

php artisan ussd:state Buy/Menu
php artisan ussd:state Buy/Product/List
php artisan ussd:state Buy/Product/Variety
php artisan ussd:state Buy/Product/Metric
php artisan ussd:state Buy/Product/Confirmation
php artisan ussd:action Buy/Product/Order

php artisan ussd:state Buy/Order/List
php artisan ussd:state Buy/Order/Confirmation

php artisan ussd:state Sell/Menu
php artisan ussd:state Sell/Product/List
php artisan ussd:state Sell/Product/Variety
php artisan ussd:state Sell/Product/Metric
php artisan ussd:state Sell/Product/Confirmation
php artisan ussd:action Sell/Product/Order

php artisan ussd:state Sell/Order/List
php artisan ussd:state Sell/Order/Confirmation

php artisan ussd:state Sell/Price/List
php artisan ussd:state Sell/Price/Confirmation
