<?php

namespace CardzApp\Modules\Shared\Application;

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

    const COLLECT_ADD_TASK = 'api.v1.collect.addTask';
    const COLLECT_GET_TASKS = 'api.v1.collect.getTasks';
    const COLLECT_UPDATE_TASK = 'api.v1.collect.updateTask';
    const COLLECT_GET_TASK = 'api.v1.collect.getTask';
    const COLLECT_UPDATE_TASK_ACTIVE = 'api.v1.collect.updateTaskActive';

    const COLLECT_ISSUE_CARD = 'api.v1.collect.issueCard';
    const COLLECT_GET_CARDS = 'api.v1.collect.getCards';
    const COLLECT_UPDATE_CARD = 'api.v1.collect.updateCard';
    const COLLECT_REJECT_CARD = 'api.v1.collect.rejectCard';
    const COLLECT_CANCEL_CARD = 'api.v1.collect.cancelCard';
    const COLLECT_REWARD_CARD = 'api.v1.collect.rewardCard';
    const COLLECT_GET_CARD = 'api.v1.collect.getCard';

    const COLLECT_ADD_ACHIEVEMENT = 'api.v1.collect.addAchievement';
    const COLLECT_GET_ACHIEVEMENTS = 'api.v1.collect.getAchievements';
    const COLLECT_REMOVE_ACHIEVEMENT = 'api.v1.collect.removeAchievement';

    const WALLET_GET_OWN_CARDS = 'api.v1.wallet.getOwnCards';
    const WALLET_GET_OWN_CARD = 'api.v1.wallet.getOwnCard';
}
