<?php

namespace Src\Core\Utils;

class Validator
{
    private array $filterSchema;
    private array $errors;
    private array $data;

    public function __construct(array $filterSchema, array $data)
    {
        $this->data = $data;
        $this->filterSchema = $filterSchema;
        $this->errors = [];

        $this->validate();
    }

    private function validate()
    {
        $data = $this->data;
        $schema = $this->filterSchema;

        foreach ($schema as $var => $filters) {
            $this->errors[$var] = [];

            if (isset($filters['required'])) {
                $filter = $filters['required'];
                if (empty(trim($data[$var])) && $filter === true) {
                    array_push(
                        $this->errors[$var],
                        $option['message'] ?? $var . ' should not be empty.'
                    );
                } else {
                    break;
                }
            }

            if (isset($filters['type'])) {
                $filter = $filters['type'];
                if (!$this->isValidType($filter, $data[$var], $var)) {
                    array_push(
                        $this->errors[$var],
                        $option['message'] ?? $var . ' should be of type ' . $filter . '.'
                    );
                }
            }

            if (isset($filters['length'])) {
                $filter = $filters['length'];
                $lowerThanMIn = is_string($data[$var]) ? strlen($data[$var]) < $filter['min'] : $data[$var] < $filter['min'];

                $higherThanMax = is_string($data[$var]) ? strlen($data[$var]) > $filter['max'] : $data[$var] > $filter['max'];

                if ($lowerThanMIn || $higherThanMax) {
                    array_push(
                        $this->errors[$var],
                        $option['message'] ?? $var . ' must be at least ' . $filter['min'] . ' and ' . $filter['max'] . ' maximum.'
                    );
                }
            }
        }
    }

    private function isValidType(string $type, mixed $data, string $var = '')
    {
        switch ($type) {
            case 'string':
                return is_string($data);
            case 'int':
                return is_int($data);
            case 'float':
                return is_float($data);
            case 'array':
                return is_array($data);
            case 'object':
                return is_object($data);
            case 'email':
                return filter_var($data, FILTER_VALIDATE_EMAIL);
            case 'boolean':
                return is_bool($data);
            case 'date':
                $pattern1 = '/^\d{4}-\d{2}-\d{2}$/';
                $pattern2 = '/^\d{2}\/\d{2}\/\d{4}$/';
                return preg_match($pattern1, $data) || preg_match($pattern2, $data);
            case 'image':
                return is_string($data) && (
                    str_contains($data, 'data:image/jpeg;base64,') ||
                    str_contains($data, 'data:image/png;base64,') ||
                    str_contains($data, 'data:image/svg+xml;base64,')
                );
            case 'gif':
                return is_string($data) && str_contains($data, 'data:image/gif;base64,');
            case 'pdf':
                return is_string($data) && str_contains($data, 'data:application/pdf;base64,');
            default:
                return false;
        }
    }

    public function getErrors()
    {
        return array_filter(
            $this->errors,
            fn($field) => sizeof($field) > 0
        );
    }

    public function isValid()
    {
        return empty($this->getErrors());
    }
}
