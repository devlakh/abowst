<?php

    /**
     *  Blurs Argument Entered
     * 
     *  @param arg
     *  @return blurred_arg 
     */
    function blur($arg)
    {
        return dechex($arg + 666);
    }

    /**
     *  Clears Blurred Argument Entered
     * 
     *  @param arg
     *  @return clear_arg 
     */
    function unblur($arg)
    {
        return hexdec($arg) - 666;
    }
?>