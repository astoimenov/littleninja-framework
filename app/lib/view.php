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

    public function renderWithSidebar($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $data{$key} = $value;
            }
        }

        require LN_PATH_VIEW . 'elements/header.php';
        require LN_PATH_VIEW . $filename . '.php';
        require LN_PATH_VIEW . 'elements/sidebar.php';
        require LN_PATH_VIEW . 'elements/footer.php';
    }
}
