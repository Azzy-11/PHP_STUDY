<?php

class Validation
{
    private ?string $name;
    private ?string $email;
    private ?string $message;

    public function __construct(?string $name = null, ?string $email = null, ?string $message = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function validate($name, $email, $message)
    {
        $this->validateName($name);
        $this->validateEmail($email);
        $this->validateMessage();

        if ($this->hasErrors()) {
            header("Location: index.php");
            exit;
        }
    }

    private function validateName()
    {
        if ($this->name === "") {
            $_SESSION['flash']['name'] = "お名前は必須項目です";
        } elseif (mb_strlen($this->name) > 17) {
            $_SESSION['flash']['name'] = "お名前は16文字以内で入力してください";
        }
        $_SESSION['original']['name'] = $this->name;
    }

    private function validateEmail()
    {
        if ($this->email === "") {
            $_SESSION['flash']['email'] = "メールアドレスは必須項目です";
        } elseif (mb_strlen($this->email) > 257) {
            $_SESSION['flash']['email'] = "メールアドレスは256文字以内で入力してください";
        }
        $_SESSION['original']['email'] = $this->email;
    }

    private function validateMessage()
    {
        if ($this->message === "") {
            $_SESSION['flash']['message'] = "お問い合わせ内容は必須項目です";
        } elseif (mb_strlen($this->message) > 301) {
            $_SESSION['flash']['message'] = "お問い合わせ内容は300文字以内で入力してください";
        }
        $_SESSION['original']['message'] = $this->message;
    }

    private function hasErrors()
    {
        return isset($_SESSION['flash']['name']) || isset($_SESSION['flash']['email']) || isset($_SESSION['flash']['message']);
    }

    private function setValidatedErrorPram() {
      if($this->hasErrors()) {
        return [$_SESSION['flash'], $_SESSION['original']];
      }
    }
}
