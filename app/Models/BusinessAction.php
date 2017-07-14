<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessAction extends Model
{
    private $allowedActions = [
        'clientAdd',
        'confirmationContacts',
        'acquaintance',
        'needs',
        'proposal',
        'order',
        'invoice',
    ];
    
    public $task = null;
    private $errors = [];
    
    public function check()
    {
        $this->errors = [];
        if(!in_array($this->action, $this->allowedActions)) {
            return false;
        }
        return $this->{$this->action}();
    }
    
    public function errors()
    {
        return $this->errors;
    }
    
    /**
     * Проверить добавление клиента
     * @return boolean
     */
    public function clientAdd()
    {
        if(empty($this->task->id)) {
            $this->errors[] = 'Невозможно проверить добавление клиента';
            return false;
        }
        
        if (empty($this->task->contractor_id)) {
            $this->errors[] = "Необходимо "
                . "<a href=\"/company#task={$this->task->id}\" >добавить клиента</a>";
            return false;
        }
        return true;
    }
    
    /**
     * Подтверждение контактов клиента
     * @return boolean
     */
    public function confirmationContacts()
    {
        if(empty($this->task->id) || empty($this->task->contractor)) {
            $this->errors[] = 'Невозможно проверить подтверждение контактов клиента';
            return false;
        }
        
        if(empty($this->task->contractor->contact->confirmed)) {
            $link = "/contractor/profile/" . $this->task->contractor->getType()
                    . "/{$this->task->contractor_id}";
            
            $this->errors[] = "Необходимо <a href=\"{$link}\" >"
                . "подтвердить контакты"
                . "</a>"
                . " клиента";
            return false;
        }
        return true;
    }
    
    /**
     * Знакомство с клиентом
     * @return boolean
     */
    public function acquaintance()
    {
        if(empty($this->task->contractor) || empty($this->task->id)
                || empty($this->task->contractor->contact)) {
            $this->errors[] = 'Невозможно проверить знакомство с клиентом';
            return false;
        }
        
        $link = "/contractor/profile/" . $this->task->contractor->getType()
                    . "/{$this->task->contractor_id}";
        
        switch ($this->task->contractor->getType()) {
            case 'user':
                if(empty($this->task->contractor->name)) {
                    $this->errors[] = "Необходимо заполнить поле \"ФИО\" в <a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(empty($this->task->contractor->contact->phone)) {
                    $this->errors[] = "Необходимо заполнить поле \"Телефон\" в <a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(empty($this->task->contractor->contact->actual_addr)) {
                    $this->errors[] = "Необходимо заполнить поле \"Адрес проживания\" в <a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a></b></u> ";
                }
                if(!empty($this->errors)) {
                    return false;
                }
                break;
            case 'company':
                if(empty($this->task->contractor->name)) {
                    $this->errors[] = "Необходимо заполнить поле \"Название\" в <a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(empty($this->task->contractor->contact->phone)) {
                    $this->errors[] = "Необходимо заполнить поле \"Телефон\" в <a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(empty($this->task->contractor->contact->actual_addr)) {
                    $this->errors[] = "Необходимо заполнить поле \"Фактический адрес\" в <u><b><a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(count($this->task->contractor->contractors) == 0) {
                    $this->errors[] = "Необходимо добавить сотрудника в <u><b><a href=\"{$link}\" >"
                        . "профиле клиента"
                    . "</a> ";
                }
                if(!empty($this->errors)) {
                    return false;
                }
                break;
        }
        return true;
    }
    
    /**
     * Выявление потребности
     * @return boolean
     */
    public function needs()
    {
        if(empty($this->task->contractor) || empty($this->task->id)) {
            $this->errors[] = 'Невозможно проверить выявление потребности';
            return false;
        }
        if ($this->task->contractor->getType() == 'company') {
            if(count($this->task->contractor->agrorotations) == 0
                    || empty($this->task->contractor->agrorotations[0]->comment)) {
                
                $link = "/contractor/profile/" . $this->task->contractor->getType()
                    . "/{$this->task->contractor_id}";
                
                $this->errors[] = "Необходимо добавить севооборот с комментарием в <u><b><a href=\"{$link}\" >"
                    . "профиле клиента"
                . "</a></b></u> ";
                return false;
            }
        }
        return true;
    }
    
    /**
     * Подготовка коммерческого предложения
     * @return boolean
     */
    public function proposal()
    {
        if(empty($this->task->id)) {
            $this->errors[] = 'Невозможно проверить подготовку коммерческого предложения';
            return false;
        }
        if(count($this->task->files) == 0) {
            $this->errors[] = 'Необходимо добавить файл с коммерческим предложением';
            return false;
        }
        return true;
    }
    
    /**
     * Оформление заказа
     * @return boolean
     */
    public function order()
    {
        if(empty($this->task->id)) {
            $this->errors[] = 'Невозможно проверить оформление заказа';
            return false;
        }
        if(count($this->task->files) == 0) {
            $this->errors[] = 'Необходимо добавить файл с заказом';
            return false;
        }
        return true;
    }
    
    /**
     * Выставление счета
     * @return boolean
     */
    public function invoice()
    {
        if(empty($this->task->id)) {
            $this->errors[] = 'Невозможно проверить выставление счета';
            return false;
        }
        if(count($this->task->files) == 0) {
            $this->errors[] = 'Необходимо добавить файл со счетом';
            return false;
        }
        return true;
    }
    
}
