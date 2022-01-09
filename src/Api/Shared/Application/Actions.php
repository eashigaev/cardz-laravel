<?php

namespace CardzApp\Api\Shared\Application;

abstract class Actions
{
    const AUTH_LOGIN = 'api.v1.auth.login';
    const AUTH_LOGOUT = 'api.v1.auth.logout';
    const AUTH_LOGOUT_ALL = 'api.v1.auth.logoutAll';

    const ACCOUNT_REGISTER_USER = 'api.v1.account.registerUser';
    const ACCOUNT_UPDATE_OWN_USER = 'api.v1.account.changeOwnUser';
    const ACCOUNT_GET_OWN_USER = 'api.v1.account.getOwnUser';

    const BUSINESS_FOUND_COMPANY = 'api.v1.business.foundCompany';
    const BUSINESS_GET_COMPANIES = 'api.v1.business.getCompanies';
    const BUSINESS_UPDATE_COMPANY = 'api.v1.business.updateCompany';
    const BUSINESS_GET_COMPANY = 'api.v1.business.getCompany';

    const COLLECT_ADD_PROGRAM = 'api.v1.collect.addProgram';
    const COLLECT_GET_PROGRAMS = 'api.v1.collect.getProgramsForCompany';
    const COLLECT_UPDATE_PROGRAM = 'api.v1.collect.updateProgram';
    const COLLECT_GET_PROGRAM = 'api.v1.collect.getProgram';
    const COLLECT_UPDATE_PROGRAM_ACTIVE = 'api.v1.collect.updateProgramActive';

    const COLLECT_ADD_PROGRAM_TASK = 'api.v1.collect.addProgramTask';
    const COLLECT_GET_PROGRAM_TASKS = 'api.v1.collect.getProgramTasks';
    const COLLECT_UPDATE_PROGRAM_TASK = 'api.v1.collect.updateProgramTask';
    const COLLECT_GET_PROGRAM_TASK = 'api.v1.collect.getProgramTask';
    const COLLECT_UPDATE_PROGRAM_TASK_ACTIVE = 'api.v1.collect.updateProgramTaskActive';

    const COLLECT_ISSUE_CARD = 'api.v1.collect.issueCard';
    const COLLECT_UPDATE_CARD = 'api.v1.collect.updateCard';
    const COLLECT_REJECT_CARD = 'api.v1.collect.rejectCard';
    const COLLECT_CANCEL_CARD = 'api.v1.collect.cancelCard';
}
