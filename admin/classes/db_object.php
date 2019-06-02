<?php

class DB_object
{
    public static function find_all()
    {
        try {
            $query = "SELECT * FROM " . static::$db_table . " ORDER BY id DESC";
            return static::find_by_query($query);
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public static function find_by_id($id)
    {
        try {
            $query = "SELECT * FROM " . static::$db_table . " WHERE id = $id";
            $the_result_array = static::find_by_query($query);
            return !empty($the_result_array) ? array_shift($the_result_array) : false;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public static function count_rows()
    {
        try {
            global $database;
            $query = "SELECT * FROM " . static::$db_table;
            $result = $database->query($query);
            $count_result = mysqli_num_rows($result);
            return $count_result;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public static function count_rows_by_id($id)
    {
        try {
            global $database;
            $query = "SELECT * FROM " . static::$db_table . " WHERE admin_id = {$id}";
            $result = $database->query($query);
            $count_result = mysqli_num_rows($result);
            return $count_result;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public static function find_by_query($sql)
    {
        try {
            global $database;
            $result_set = $database->query($sql);
            $the_object_array = array();
            while ($row = mysqli_fetch_assoc($result_set)) {
                $the_object_array[] = static::instantiation($row);
            }
            return $the_object_array;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public static function instantiation($the_record)
    {
        try {
            $calling_class = get_called_class();
            $the_object = new $calling_class;

            foreach ($the_record as $the_attribute => $value) {
                if ($the_object->has_the_attribute($the_attribute)) {
                    $the_object->$the_attribute = $value;
                }
            }

            return $the_object;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    private function has_the_attribute($the_attribute)
    {
        try {
            $object_properties = get_object_vars($this);
            return array_key_exists($the_attribute, $object_properties);
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    //dynamically created property
    protected function properties()
    {
        try {
            $properties = array();
            foreach (static::$db_table_field as $db_field) {
                if (property_exists($this, $db_field)) {
                    $properties[$db_field] = $this->$db_field;
                }
            }
            return $properties;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }

    }

    //dynamically cleaning properties
    protected function clean_properties()
    {
        try {
            global $database;
            $clean_properties = array();

            foreach ($this->properties() as $key => $value) {
                $clean_properties[$key] = $database->escape_string($value);
            }
            return $clean_properties;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public function save()
    {
        try {
            return isset($this->id) ? $this->update() : $this->create();
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    //dynamically create method(also can use another class)
    public function create()
    {
        try {
            global $database;

            $properties = $this->clean_properties();

            $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
            $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

            //print_r($sql);

            if ($database->query($sql)) {
                $this->id = $database->the_insert_id();
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    //dynamically create update method(also can use another class)
    public function update()
    {
        try {
            global $database;

            $properties = $this->clean_properties();
            $property_pairs = array();

            foreach ($properties as $key => $value) {
                $property_pairs[] = "{$key}='{$value}'";
            }

            $sql = "UPDATE " . static::$db_table . " SET ";
            $sql .= implode(", ", $property_pairs);
            $sql .= " WHERE id = {$this->id}";

            //print_r($sql);

            $database->query($sql);

            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }


    public function delete()
    {
        try {
            global $database;

            $sql = "DELETE FROM " . static::$db_table . " WHERE id = {$database->escape_string($this->id)} LIMIT 1";

            $database->query($sql);

            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }
    
    public function update_by_id($file=null,$id=null)
    {
         try {
            global $database;
           //$sql='UPDATE `tbl_contract` SET signature="$file" WHERE id="$id"';
           $sql="UPDATE tbl_contract SET signature='$file' WHERE id='$id'";
           $database->query($sql);
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
        
    }
}

?>