<?php
class Csrf
{
  private ?string $postToken;
  private ?string $sessionToken;

  public function __construct(?string $postToken = null, ?string $sessionToken = null)
  {
    $this->postToken = $postToken;
    $this->sessionToken = $sessionToken;
  }

  public function createToken() : string {
    return bin2hex(random_bytes(16));
  }

  public function validateToken() :bool {
    $postToken = $this->postToken;
    $sessionToken = $this->sessionToken;
    return $postToken !== "" && $sessionToken !== "" && $postToken === $sessionToken;
  }

  public function redirectToIndex() {
    if (!$this->validateToken()) {
      header("Location: index.php");
      exit;
    }
  }
}