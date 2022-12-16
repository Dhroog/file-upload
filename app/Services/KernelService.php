<?php


namespace App\Services;


class KernelService
{
    public $FileService;
    public $GroupService;
    public $UserServeice;

    public function __construct()
    {
        $this->FileService = new FileService();
        $this->GroupService = new GroupService();
        $this->UserServeice = new UserService();
    }
}
