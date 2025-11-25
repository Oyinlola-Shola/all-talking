<?php
namespace NewdichSchema;

class Settings{
    public const APP_VERSION ="2.1.0";
    public const APP_NAME ="newdich";
    public const APP_TITLE ="";
    public const APP_DESCRIPTION ="";
    public const APP_SMTP ="";
    public const APP_PORT = "";
    public const APP_OTP_EMAIL ="";
    public const APP_OTP_EMAIL_PASSWORD ="";
    public const APP_SENDING_EMAIL ="";
    public const APP_SENDING_EMAIL_PASSWORD ="";

    //for annotations
    public const APP_ANNOTATION_TITLE = self::APP_NAME . " App(Users Area) Endpoints";
    public const SRC_ANNOTATION_TITLE = self::APP_NAME . " Src(Admins Area) Endpoints";

    //set server configuration
    public const SERVER ="localhost";
    public const SERVER_USER ="root";
    public const SERVER_DB ="user";
    public const SERVER_PASS ="mysql";

    //other configuration
    public const DOMAIN_NAME ="";
    public const AUTH_KEY = "ANSOFRA.NEWDICH.TECHNOLOGY.www.newdich.tech"; //you can change this to anything, make sure it's safe
}
?>