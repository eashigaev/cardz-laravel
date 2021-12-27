<?php

namespace CardzApp\Api\Shared\Application;

abstract class Actions
{
    const AUTH_LOGIN_ACTION = 'api.v1.auth.login';
    const AUTH_LOGOUT_ACTION = 'api.v1.auth.logout';
    const AUTH_LOGOUT_ALL_ACTION = 'api.v1.auth.logoutAll';

    const ACCOUNT_REGISTER_USER_ACTION = 'api.v1.account.registerUser';
    const ACCOUNT_GET_AUTH_USER_ACTION = 'api.v1.account.getUser';
    const ACCOUNT_UPDATE_AUTH_USER_ACTION = 'api.v1.account.changeUser';

    const BUSINESS_GET_COMPANIES = 'api.v1.business.getCompanies';
    const BUSINESS_FOUND_COMPANY = 'api.v1.business.foundCompany';
    const BUSINESS_UPDATE_COMPANY = 'api.v1.business.updateCompany';
    const BUSINESS_GET_COMPANY = 'api.v1.business.getCompany';

    const COLLECT_ADD_PROGRAM = 'api.v1.collect.addProgram';
}
