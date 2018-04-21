<?php

function formatDateTime($format, $date)
{
    if (isnull($date)) {
        return "";
    } else {
        return ucfirst(iconv("iso-8859-1", "utf-8", strftime($format, strtotime($date))));
    }

}