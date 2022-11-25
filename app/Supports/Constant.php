<?php

namespace App\Supports;

/**
 * Class Constant
 */
class Constant
{
    /**
     * System Model Status
     */
    const ENABLED_OPTIONS = ['yes' => 'Yes', 'no' => 'No'];

    /**
     * System Executive Roles
     */
    const EXECUTIVE_ROLES = [1, 2];

    /**
     * System Public Roles
     */
    const VISIBLE_ROLES = [2, 3, 4, 5, 6, 7];

    /**
     * System Model Status
     */
    const GUEST_ROLE_ID = 4;

    /**
     * System User Permission Guards
     */
    const PERMISSION_GUARDS = ['web' => 'WEB'];

    /**
     * System User Permission Guard
     */
    const PERMISSION_GUARD = 'web';

    /**
     * System Permission Title Constraint
     */
    const PERMISSION_NAME_ALLOW_CHAR = '([a-zA-Z0-9.-_]+)';

    /**
     * Keyword to purge Soft Deleted Models
     */
    const PURGE_MODEL_QSA = 'purge';

    /**
     * Timing Constants
     */
    const SECOND = '1';

    const MINUTE = '60';

    const HOUR = '3600';

    const DAY = '86400';

    const WEEK = '604800';

    const MONTH = '2592000';

    const YEAR = '31536000';

    const DECADE = '315360000'; //1de=10y

    /**
     * Toastr Message Levels
     */
    const MSG_TOASTR_ERROR = 'error';

    const MSG_TOASTR_WARNING = 'warning';

    const MSG_TOASTR_SUCCESS = 'success';

    const MSG_TOASTR_INFO = 'info';

    /**
     * Authentication Login Medium
     */
    const LOGIN_EMAIL = 'email';

    const LOGIN_USERNAME = 'username';

    const LOGIN_MOBILE = 'mobile';

    const LOGIN_OTP = 'otp';

    /**
     * OTP Medium Source
     */
    const OTP_MOBILE = 'mobile';

    const OTP_EMAIL = 'email';

    const EXPORT_OPTIONS = [
        'xlsx' => 'Microsoft Excel (.xlsx)',
        'ods' => 'Open Document Spreadsheet (.ods)',
        /*        'csv' => 'Comma Seperated Values (.csv)'*/
    ];

    /**
     * Default Role Name for system administrator
     */
    const SUPER_ADMIN_ROLE = 'Super Administrator';

    /**
     * Default Email Address for backend admin panel
     */
    const EMAIL = 'hafijul233@gmail.com';

    /**
     * Default model enabled status
     */
    const ENABLED_OPTION = 'yes';

    /**
     * Default model disabled statusENABLED_OPTION
     */
    const DISABLED_OPTION = 'no';

    /**
     * Default Password
     */
    const PASSWORD = 'password';

    /**
     * Default profile display image is user image is missing
     */
    const USER_PROFILE_IMAGE = 'assets/img/logo.png';

    /**
     * Default Logged User Redirect Route
     */
    const DASHBOARD_ROUTE = 'backend.dashboard';

    const LOCALE = 'en';

    /**
     * Default Exp[ort type
     */
    const EXPORT_DEFAULT = 'xlsx';

    /**
     * CATALOG TYPES
     */
    const CATALOG_TYPE = [
        'GENDER' => 'GEN',
        'MARITAL_STATUS' => 'MAS',
        'RELIGION' => 'REL',
        'UNIVERSITY' => 'UNI',
        'BOARD' => 'BOR',
        'QUOTA' => 'QOT',
    ];

    /**
     * CATALOG TYPES
     */
    const CATALOG_LABEL = [
        'GEN' => 'Gender',
        'MAS' => 'Marital Status',
        'REL' => 'Religion',
        'UNI' => 'University',
        'BOR' => 'Board',
        'QOT' => 'Quote',
    ];

    const GPA_TYPE = [
        1 => '1st Division',
        2 => '2nd Division',
        3 => '3rd Division',
        4 => 'GPA(Out of 4)',
        5 => 'GPA(Out of 5)',
        6 => 'Others',

    ];

    const LOCALES = [
        'en' => 'English',
        'bd' => 'Bangla',
    ];

    const WORKED_EARLIER = 1;

    const WORK_IN_FUTURE = 2;

    const USA_STATE = [
        'AK' => 'AK - Alaska',
        'AL' => 'AL - Alabama',
        'AR' => 'AR - Arkansas',
        'AS' => 'AS - American Samoa',
        'AZ' => 'AZ - Arizona',
        'CA' => 'CA - California',
        'CO' => 'CO - Colorado',
        'CT' => 'CT - Connecticut',
        'DC' => 'DC - District of Columbia',
        'DE' => 'DE - Delaware',
        'FL' => 'FL - Florida',
        'GA' => 'GA - Georgia',
        'GU' => 'GU - Guam',
        'HA' => 'HI - Hawaii',
        'IA' => 'IA - Iowa',
        'ID' => 'ID - Idaho',
        'IL' => 'IL - Illinois',
        'IN' => 'IN - Indiana',
        'KS' => 'KS - Kansas',
        'KY' => 'KY - Kentucky',
        'LA' => 'LA - Louisiana',
        'MA' => 'MA - Massachusetts',
        'MD' => 'MD - Maryland',
        'ME' => 'ME - Maine',
        'MI' => 'MI - Michigan',
        'MN' => 'MN - Minnesota',
        'MO' => 'MO - Missouri',
        'MS' => 'MS - Mississippi',
        'MT' => 'MT - Montana',
        'NC' => 'NC - North Carolina',
        'ND' => 'ND - North Dakota',
        'NE' => 'NE - Nebraska',
        'NH' => 'NH - New Hampshire',
        'NJ' => 'NJ - New Jersey',
        'NM' => 'NM - New Mexico',
        'NV' => 'NV - Nevada',
        'NY' => 'NY - New York',
        'OH' => 'OH - Ohio',
        'OK' => 'OK - Oklahoma',
        'OR' => 'OR - Oregon',
        'PA' => 'PA - Pennsylvania',
        'PR' => 'PR - Puerto Rico',
        'RI' => 'RI - Rhode Island',
        'SC' => 'SC - South Carolina',
        'SD' => 'SD - South Dakota',
        'TN' => 'TN - Tennessee',
        'TX' => 'TX - Texas',
        'UT' => 'UT - Utah',
        'VA' => 'VA - Virginia',
        'VI' => 'VI - Virgin Islands',
        'VT' => 'VT - Vermont',
        'WA' => 'WA - Washington',
        'WI' => 'WI - Wisconsin',
        'WV' => 'WV - West Virginia',
        'WY' => 'WY - Wyoming',
    ];
}
