<?php

class PhergeonFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openAnimalesPage(\FunctionalTester $I)
    {
        $I->see('Bienvenido a Phergeon', 'h2');

    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\Usuarios::findOne(['nombre_usuario' => 'danigove']));
        $I->amOnPage('site/index');
        $I->see('Bienvenido a Phergeon', 'h2');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findOne(['nombre_usuario' => 'danigove']));
        $I->amOnPage('/');
        $I->see('Logout (danigove)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Usuario no puede estar vacío.');
        $I->see('Contraseña no puede estar vacío.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'danigove',
            'LoginForm[password]' => 'danigovee',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Contraseña incorrecta.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'danigove',
            'LoginForm[password]' => 'danigove',
        ]);
        $I->see('Logout (danigove)');
        $I->dontSeeElement('form#login-form');
    }
}
