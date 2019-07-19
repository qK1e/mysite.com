<?php


namespace qk1e\mysite\model;

interface UsersDatabase
{
    public function registerUser($login, $password);
}