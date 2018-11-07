<?php
/**
 * Created by PhpStorm.
 * User: gf
 * Date: 2018/1/31
 * Time: 16:13
 */

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">appid</label>

                        <div class="col-sm-10"><input type="text" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">appsecret</label>
                        <div class="col-sm-10"><input type="text" class="form-control"> <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group has-success"><label class="col-sm-2 control-label">Input with success</label>

                        <div class="col-sm-10"><input type="text" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group has-warning"><label class="col-sm-2 control-label">Input with warning</label>

                        <div class="col-sm-10"><input type="text" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group has-error"><label class="col-sm-2 control-label">Input with error</label>

                        <div class="col-sm-10"><input type="text" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Control sizing</label>

                        <div class="col-sm-10"><input type="text" placeholder=".input-lg" class="form-control input-lg m-b">
                            <input type="text" placeholder="Default input" class="form-control m-b"> <input type="text" placeholder=".input-sm" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Button addons</label>

                        <div class="col-sm-10">
                            <div class="input-group m-b"><span class="input-group-btn">
                                            <button type="button" class="btn btn-primary">Go!</button> </span> <input type="text" class="form-control">
                            </div>
                            <div class="input-group"><input type="text" class="form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-primary">Go!
                                        </button> </span></div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white" type="submit">取消</button>
                            <button class="btn btn-primary" type="submit">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="row">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Data Picker <small>https://github.com/eternicode/bootstrap-datepicker</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <h3>
                    Data picker
                </h3>
                <p>
                    Simple and easy select a time for a text input using your mouse.
                </p>

                <div class="form-group" id="data_1">
                    <label class="font-normal">Simple data input format</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                    </div>
                </div>

                <div class="form-group" id="data_2">
                    <label class="font-normal">One Year view</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="08/09/2014">
                    </div>
                </div>

                <div class="form-group" id="data_3">
                    <label class="font-normal">Decade view</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="10/11/2013">
                    </div>
                </div>

                <div class="form-group" id="data_4">
                    <label class="font-normal">Month select</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
                    </div>
                </div>

                <div class="form-group" id="data_5">
                    <label class="font-normal">Range select</label>
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" value="05/14/2014"/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end" value="05/22/2014" />
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <h5>ClockPicker <small>http://weareoutman.github.io/clockpicker/</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <h3>
                    ClockPicker
                </h3>
                <p>
                    A clock-style timepicker for Bootstrap (or jQuery).
                </p>

                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" class="form-control" value="09:30" >
                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Date Range Picker <small>http://www.daterangepicker.com/</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <h3>
                    Date Range Picker
                </h3>
                <p>
                    A JavaScript widget for choosing date ranges.
                    Designed to work with the Bootstrap CSS framework.
                </p>

                <input class="form-control" type="text" name="daterange" value="01/01/2015 - 01/31/2015" />

                <h4>All options example</h4>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>
                    <span></span> <b class="caret"></b>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins">
            <div class="ibox-title  back-change">
                <h5>Color picker <small>http://mjolnic.github.io/bootstrap-colorpicker/</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <h3>
                    Colorpicker
                </h3>
                <p>
                    Colorpicker plugin for the Twitter Bootstrap toolkit.
                </p>

                <h5>As normal input</h5>
                <input type="text" class="form-control demo1" value="#5367ce" />
                <h5>As a link</h5>
                <a data-color="rgb(255, 255, 255)" id="demo_apidemo" class="btn btn-white btn-block colorpicker-element" href="#">Change background color</a>
                <br/>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Bootstrap Tags Input</h5>
            </div>
            <div class="ibox-content">
                <p>
                    jQuery plugin providing a Twitter Bootstrap user interface for managing tags
                </p>


                <p class="font-bold">
                    Basic example with few initial tags
                </p>

                <input class="tagsinput form-control" type="text" value="Amsterdam,Washington,Sydney,Beijing,Cairo"/>


            </div>
        </div>

    </div>

</div>