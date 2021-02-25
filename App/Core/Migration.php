<?php
namespace App\Core;

use App\Models\Auth;
use App\Models\Bonus;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Profile;
use App\Models\Referral;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;

class Migration extends QueryBuilder
{
    public static function roleTable()
    {
        $values = "id TINYINT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "role VARCHAR(40) NOT NULL";
        $result = QueryBuilder::create(Role::$table, $values);

        return $result;
    }

    public static function userTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "role_id TINYINT NOT NULL, ";
        $values .= "email VARCHAR(40) NOT NULL, ";
        $values .= "pass VARCHAR(100) NOT NULL, ";
        $values .= "joined_at DATE NOT NULL";

        $result = QueryBuilder::create(User::$table, $values);

        return $result;
    }

    public static function authTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "is_email_verfied BOOLEAN NOT NULL, ";
        $values .= "email_verification_token VARCHAR(40) NOT NULL, ";
        $values .= "email_verification_token_expiry TIME NOT NULL, ";
        $values .= "email_verified_at DATE NOT NULL, ";
        $values .= "login_code VARCHAR(10), ";
        $values .= "login_code_expiry TIME, ";
        $values .= "is_active BOOLEAN NOT NULL, ";
        $values .= "is_deleted BOOLEAN NOT NULL, ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id)";

        $result = QueryBuilder::create(Auth::$table, $values);

        return $result;
    }

    public static function profileTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "firstname VARCHAR(40) NOT NULL, ";
        $values .= "lastname VARCHAR(40) NOT NULL, ";
        $values .= "country VARCHAR(40) NOT NULL, ";
        $values .= "state VARCHAR(40) NOT NULL, ";
        $values .= "city VARCHAR(40) NOT NULL, ";
        $values .= "address VARCHAR(100) NOT NULL, ";
        $values .= "phone VARCHAR(20) NOT NULL, ";
        $values .= "INDEX(user_id), ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id) ";

        $result = QueryBuilder::create(Profile::$table, $values);

        return $result;
    }

    public static function walletTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "balance INT NOT NULL, ";
        $values .= "withdrawable INT NOT NULL, ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id) ";

        $result = QueryBuilder::create(Wallet::$table, $values);

        return $result;
    }

    public static function packageTable()
    {
        $values = "id TINYINT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "package_name VARCHAR(20) NOT NULL, ";
        $values .= "period TIME NOT NULL, ";
        $values .= "interest VARCHAR(5) NOT NULL";

        $result = QueryBuilder::create(Package::$table, $values);

        return $result;
    }

    public static function bonusTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "investment_id INT NOT NULL, ";
        $values .= "bonus MEDIUMINT NOT NULL, ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id)";

        $result = QueryBuilder::create(Bonus::$table, $values);

        return $result;
    }

    public static function investmentTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "package_id TINYINT NOT NULL, ";
        $values .= "amount INT NOT NULL, ";
        $values .= "accumulated_amount INT NOT NULL, ";
        $values .= "is_active BOOLEAN NOT NULL, ";
        $values .= "is_withdrawn_to_wallet BOOLEAN NOT NULL, ";
        $values .= "date_updated CURRENT_TIMESTAMP, ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id), ";
        $values .= "FOREIGN KEY(package_id) REFERENCES packages(id)";

        $result = QueryBuilder::create(Investment::$table, $values);

        return $result;
    }

    public static function withdrawalTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "user_id INT NOT NULL, ";
        $values .= "amount INT NOT NULL, ";
        $values .= "status BOOLEAN NOT NULL, ";
        $values .= "FOREIGN KEY(user_id) REFERENCES users(id)";

        $result = QueryBuilder::create(Withdrawal::$table, $values);

        return $result;
    }

    public static function referralTable()
    {
        $values = "id INT PRIMARY KEY AUTO_INCREMENT, ";
        $values .= "referrer INT NOT NULL, ";
        $values .= "referred INT NOT NULL, ";
        $values .= "FOREIGN KEY(referrer, referred) REFERENCES users(id, id) ON UPDATE CASCADE ON DELETE CASCADE";
        $result = QueryBuilder::create(Referral::$table, $values);

        return $result;
    }
}
