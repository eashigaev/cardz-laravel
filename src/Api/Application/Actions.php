<?php

namespace CardzApp\Api\Application;

abstract class Actions
{
    const AUTH_LOGIN_ACTION = 'api.v1.auth.login';
    const AUTH_LOGOUT_ACTION = 'api.v1.auth.logout';
    const AUTH_LOGOUT_ALL_ACTION = 'api.v1.auth.logoutAll';

    const ACCOUNT_REGISTER_USER_ACTION = 'api.v1.account.registerUser';
    const ACCOUNT_GET_AUTH_USER_ACTION = 'api.v1.account.getUser';
    const ACCOUNT_UPDATE_AUTH_USER_ACTION = 'api.v1.account.changeUser';
}
