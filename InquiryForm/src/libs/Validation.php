<?php
declare(strict_types=1);

final class Validation
{
    public static function validate(): void
    {
        $name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
        $email = isset($_POST["email"]) && is_string($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
        $message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';
        self::validateName($name);
        self::validateEmail($email);
        self::validateMessage($message);

        if (self::hasErrors()) {
            header("Location: index.php");
            exit;
        }
    }

    private static function validateName(string $name): void
    {
        if ($name === "") {
            $_SESSION['flash']['name'] = "お名前は必須項目です";
        } elseif (mb_strlen($name) > 17) {
            $_SESSION['flash']['name'] = "お名前は16文字以内で入力してください";
        }
        $_SESSION['original']['name'] = $name;
    }

    private static function validateEmail(string $email): void
    {
        if ($email === "") {
            $_SESSION['flash']['email'] = "メールアドレスは必須項目です";
        } elseif (mb_strlen($email) > 257) {
            $_SESSION['flash']['email'] = "メールアドレスは256文字以内で入力してください";
        }
        $_SESSION['original']['email'] = $email;
    }

    private static function validateMessage(string $message): void
    {
        if ($message === "") {
            $_SESSION['flash']['message'] = "お問い合わせ内容は必須項目です";
        } elseif (mb_strlen($message) > 301) {
            $_SESSION['flash']['message'] = "お問い合わせ内容は300文字以内で入力してください";
        }
        $_SESSION['original']['message'] = $message;
    }

    private static function hasErrors(): bool
    {
        return isset($_SESSION['flash']['name']) || isset($_SESSION['flash']['email']) || isset($_SESSION['flash']['message']);
    }

    public static function setValidatedErrorParam(): array 
    {
        return [
            isset($_SESSION['flash']) ? $_SESSION['flash'] : null, 
            isset($_SESSION['original']) ? $_SESSION['original'] : null, 
        ];
    }
}
