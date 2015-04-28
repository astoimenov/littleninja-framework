<?php namespace LittleNinja\Lib;

class View
{
    public function render($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $data{$key} = $value;
            }
        }

        require LN_PATH_VIEW . 'elements/header.php';
        require LN_PATH_VIEW . $filename . '.php';
        require LN_PATH_VIEW . 'elements/footer.php';
    }

    public function renderMulti($filenames, $data = null)
    {
        if (!is_array($filenames)) {
            self::render($filenames, $data);
            return false;
        }
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
        require LN_PATH_VIEW . '_templates/header.php';
        foreach ($filenames as $filename) {
            require LN_PATH_VIEW . $filename . '.php';
        }
        require LN_PATH_VIEW . '_templates/footer.php';
    }

    public function renderJSON($data)
    {
        echo json_encode($data);
    }
}
