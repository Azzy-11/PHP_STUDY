<?php
class Request
{
  private const POST = "POST";
  private string $method;

  function __construct(string $requestMethod) {
    $this->method = $requestMethod;
  }

  public function isPost() : bool {
    return $this->method === self::POST;
  }

  public function redirectToIndex() {
    if (!$this->isPost()) {
      header("Location: index.php");
      exit;
    }
  }
}