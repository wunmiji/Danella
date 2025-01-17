<?php

namespace App\ImplModel;


use App\Models\Employee\EmployeeModel;
use App\Models\Employee\EmployeeImageModel;
use App\Models\Employee\EmployeeContactModel;
use App\Models\Employee\EmployeeSecretModel;
use App\Models\Employee\EmployeeSecretResetModel;
use App\Libraries\DateLibrary;
use App\Entities\Employee\EmployeeEntity;
use App\Entities\Employee\EmployeeImageEntity;
use App\Entities\Employee\EmployeeContactEntity;
use App\Entities\Employee\EmployeeSecretEntity;
use App\Entities\Employee\EmployeeSecretResetEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;


/**
 * 
 */

class EmployeeImplModel
{


    public function list(int $from, int $to)
    {
        $employeeModel = new EmployeeModel();
        $query = $employeeModel->query($employeeModel->sqlId, [
            'from' => $from,
            'to' => $to,
        ]);
        $list = $query->getResultArray();

        $output = array();
        foreach ($list as $key => $value) {
            array_push($output, $this->retrieve($value['EmployeeId']));
        }

        return $output;
    }


    public function retrieve(int $num)
    {
        $employeeModel = new EmployeeModel();
        $query = $employeeModel->query($employeeModel->sqlEmployee, [
            'employeeId' => $num,
        ]);
        $row = $query->getRowArray();

        if (is_null(($row)))
            return null;
        else {
            return $this->employee($row);
        }
    }

    public function employee($value)
    {
        return new EmployeeEntity(
            $value['EmployeeId'] ?? null,
            $value['EmployeeFirstName'] . ' ' . $value['EmployeeLastName'],
            $value['EmployeeFirstName'] ?? null,
            $value['EmployeeLastName'] ?? null,
            $value['EmployeeDescription'] ?? null,

            DateLibrary::getFormat($value['CreatedDateTime '] ?? null),
            DateLibrary::getFormat($value['ModifiedDateTime'] ?? null),

            $this->employeeImage($value['EmployeeId']) ?? null,
            $this->employeeContact($value['EmployeeId']) ?? null,
            $this->employeeSecret($value['EmployeeId'] ?? null)
        );

    }

    public function employeeImage(int $num)
    {
        $employeeImageModel = new EmployeeImageModel();
        $query = $employeeImageModel->query($employeeImageModel->sqlFile, [
            'employeeId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new EmployeeImageEntity(
            $num,
            $arr['FileId'] ?? null,
            $arr['FileManagerUrlPath'] . DIRECTORY_SEPARATOR . $arr['FileManagerFileName'],
            $arr['FileManagerFileName'] ?? null,
        );

        return $entity;
    }

    public function employeeContact(int $num)
    {
        $employeeContactModel = new EmployeeContactModel();
        $query = $employeeContactModel->query($employeeContactModel->sqlContact, [
            'employeeId' => $num,
        ]);

        //echo $query;
        $arr = $query->getRowArray();

        $entity = new EmployeeContactEntity(
            $num,
            $arr['EmployeeContactEmail'] ?? null,
            $arr['EmployeeContactMobile'] ?? null,
            $arr['EmployeeContactTelephone'] ?? null
        );

        return $entity;
    }

    public function employeeSecret(int $num)
    {
        $employeeSecretModel = new EmployeeSecretModel();
        $query = $employeeSecretModel->query($employeeSecretModel->sqlSecret, [
            'employeeId' => $num,
        ]);
        $arr = $query->getRowArray();

        $entity = new EmployeeSecretEntity(
            $num,
            $arr['EmployeeSecretSalt'] ?? null,
            $arr['EmployeeSecretPassword'] ?? null
        );

        return $entity;
    }

    public function employeeSecretReset(string $token)
    {
        $employeeSecretResetModel = new EmployeeSecretResetModel();
        $query = $employeeSecretResetModel->query($employeeSecretResetModel->sqlToken, [
            'employeeSecretResetToken' => $token
        ]);
        $row = $query->getRowArray();
        if (is_null($row)) return null;
        else {
            return new EmployeeSecretResetEntity(
                $row['EmployeeId'] ?? null,
                $token,
                $row['EmployeeSecretExpiresAt'] ?? null
            );
        }
    }

    public function update($num, $data, $dataImage, $dataContact)
    {
        try {
            $employeeModel = new EmployeeModel();

            $employeeModel->transException(true)->transStart();

            // Update into employee
            $data['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $employeeModel->update($num, $data);

            // Update into employee_image
            $employeeImageModel = new EmployeeImageModel();
            $employeeImageModel->update($num, $dataImage);

            // Update into employee_contact
            $employeeContactModel = new EmployeeContactModel();
            $employeeContactModel->update($num, $dataContact);

            $employeeModel->transComplete();

            if ($employeeModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function updateSecret($num, $dataSecret, $forgetPassword)
    {
        try {
            $employeeSecretModel = new EmployeeSecretModel();

            $employeeSecretModel->transException(true)->transStart();

            // Update into employee_secret
            $employeeSecretModel->update($num, $dataSecret);

            // Delete forgetPassword if true
            if ($forgetPassword === true) {
                $employeeSecretResetModel = new EmployeeSecretResetModel();
                $employeeSecretResetModel->delete($num);
            }

            // Update into employee
            $employeeModel = new EmployeeModel();
            $dataEmployee['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $employeeModel->update($num, $dataEmployee);

            $employeeSecretModel->transComplete();

            if ($employeeSecretModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }

    public function saveSecretReset($num, $dataSecretReset)
    {
        try {
            $employeeSecretResetModel = new EmployeeSecretResetModel();

            $employeeSecretResetModel->transException(true)->transStart();

            // Update into employee_secret_reset
            $employeeSecretResetModel->delete($num);
            $employeeSecretResetModel->insert($dataSecretReset);

            // Update into employee
            $employeeModel = new EmployeeModel();
            $dataEmployee['ModifiedDateTime'] = DateLibrary::getZoneDateTime();
            $employeeModel->update($num, $dataEmployee);

            $employeeSecretResetModel->transComplete();

            if ($employeeSecretResetModel->transStatus() === false)
                return false;
            else
                return true;
        } catch (DatabaseException $e) {
            d($e);
        }
    }


    // Other 
    public function getIdByEmail(string $email)
    {
        $employeeModel = new EmployeeModel();
        $query = $employeeModel->query($employeeModel->sqlEmail, [
            'employeeContactEmail' => $email
        ]);
        $row = $query->getRow();
        return (is_null($row)) ? null : $row->{'EmployeeId'};
    }

    


}