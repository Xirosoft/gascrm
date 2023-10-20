<?php
if ( ! function_exists('taskStatus')) {
    function taskStatus()
    {
        return ['Not Started', 'In Progress', 'Waiting', 'Completed', 'Deferred'];
    }
}
if ( ! function_exists('taskPriority')) {
    function taskPriority()
    {
        return ['High', 'Normal', 'Low'];
    }
}
if ( ! function_exists('actionableColumn')) {
    function actionableColumn($data)
    {
        if ($data->actionable_type != null) {
            $event = str_replace('App\Models\\', '', $data->actionable_type);
            $link = route(strtolower($event).'.show', $data->actionable_id);
            return '<a href="'.$link.'" target="_blank">'.$event.'</a>';
        }
    }
}
if ( ! function_exists('adminAccess')) {
    function adminAccess($user)
    {
        if ($user->type == 'Admin') {
            return true;
        }
        return false;
    }
}

//url with query string
if ( ! function_exists('qUrl')) {
    function qUrl($queryArr = null, $route = null)
    {
        $route = $route ?? url()->current();
        return $route.qString($queryArr);
    }
}

//Search string get and set an url
if ( ! function_exists('qString')) {
    function qString($queryArr = null)
    {
        if (!empty($queryArr)) {
            $query = '';

            if (!empty($_GET)) {
                $getArray = $_GET;
                unset($getArray['page']);

                foreach ($queryArr as $qk => $qv) {
                    unset($getArray[$qk]);
                }

                $x = 0;
                foreach ($getArray as $gk => $gt) {
                    $query .= ($x != 0) ? '&' : '';
                    $query .= $gk.'='.$gt;
                    $x++;
                }
            }
            
            $y = 0;
            foreach ($queryArr as $qk => $qv) {
                if ($qv != null) {
                    $query .= ($y != 0 || $query != '') ? '&' : '';
                    $query .= $qk.'='.$qv;
                    $y++;
                }
            }

            return '?'.$query;

        } elseif (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != null) {
            return '?'.$_SERVER['QUERY_STRING'];
        }
    }
}

//Search Aray get to route redirect with get param
if ( ! function_exists('qArray')) {
    function qArray()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            return $_GET;
        } else {
            return null;
        }
    }
}

//Pagination per page
if ( ! function_exists('paginations')) {
    function paginations()
    {
        return ['15', '25', '50', '100'];
    }
}

//Pagination Message...
if ( ! function_exists('pagiMsg')) {
    function pagiMsg($data)
    {
        $msg = 'Showing ';
        $msg .= (($data->currentPage()*$data->perPage())-$data->perPage())+1;
        $msg .= ' to ';
        $msg .= ($data->currentPage()*$data->perPage()>$data->total()) ? $data->total() : $data->currentPage()*$data->perPage().' of '.$data->total();
        $msg .= ' row(s)';

        return $msg;
    }
}

//Date Format
if ( ! function_exists('dateFormat')) {
    function dateFormat($date, $time = null)
    {
        if ($time) {
            return date('d M, Y h:i A', strtotime($date));
        } else {
            return date('d M, Y', strtotime($date));
        }
    }
}

//Time Format
if ( ! function_exists('timeFormat')) {
    function timeFormat($date)
    {
        return date('h:i A',(strtotime($date)));
    }
}

if ( ! function_exists('sizeFormat')) {
    function sizeFormat($bytes)
    {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
    }
}
