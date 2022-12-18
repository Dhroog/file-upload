<?php


namespace App\Services;


class KernelService
{
    public $FileService;
    public $GroupService;
    public $UserService;

    public function __construct()
    {
        $this->FileService = new FileService();
        $this->GroupService = new GroupService();
        $this->UserService = new UserService();
    }
}
