<?php
include('modules/email/send/style/block/block_getinfo.php');
$message .= '<STYLE type="text/css">'."\n";
include('modules/email/send/style/block/block_createcontent.php');
$message .= '</STYLE>';
//$message .= '<STYLE type="text/css">
//             .block_main1
//            {
//            border-radius: 0px 0px 8px 8px;
//            -moz-border-radius: 0px 0px 8px 8px;
//            -webkit-border-radius: 0px 0px 8px 8px;
//            background-color: #FFFFFF;
//            width: 100%;
//            height: 100%;
//            padding: 4px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_main2
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #FFFFFF;
//            width: 100%;
//            height: 100%;
//            padding: 4px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_main3
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 0px 0px 8px 8px;
//            -moz-border-radius: 0px 0px 8px 8px;
//            -webkit-border-radius: 0px 0px 8px 8px;
//            background-color: #FFFFFF;
//            width: 180px;
//            height: 100%;
//            padding: 2px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_main4
//            {
//            }
//
//            .block_main5
//            {
//            background-color: transparent;
//            width: 100%;
//            height: 100%;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_title1
//            {
//            border-radius: 8px 8px 0px 0px;
//            -moz-border-radius: 8px 8px 0px 0px;
//            -webkit-border-radius: 8px 8px 0px 0px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            font-size: 14px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_title2
//            {
//            border-radius: 8px 8px 0px 0px;
//            -moz-border-radius: 8px 8px 0px 0px;
//            -webkit-border-radius: 8px 8px 0px 0px;
//            background-color: #F2F2F2;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 12px;
//            font-weight: bold;
//            color: #0B3B02;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_title3
//            {
//            border-radius: 8px 8px 0px 0px;
//            -moz-border-radius: 8px 8px 0px 0px;
//            -webkit-border-radius: 8px 8px 0px 0px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            font-size: 16px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_title4
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Arial\', \'Helvetica\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_title5
//            {
//            }
//
//            .block_msg1
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #8C0101;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 14px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_msg2
//            {
//            }
//
//            .block_msg3
//            {
//            }
//
//            .block_msg4
//            {
//            }
//
//            .block_msg5
//            {
//            }
//
//            .block_error1
//            {
//            }
//
//            .block_error2
//            {
//            }
//
//            .block_error3
//            {
//            }
//
//            .block_error4
//            {
//            }
//
//            .block_error5
//            {
//            }
//
//            .block_listing1
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Arial\', \'Helvetica\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_listing2
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #FFFFFF;
//            width: 100%;
//            height: 100%;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_listing3
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #FFFFFF;
//            width: 100%;
//            height: 100%;
//            padding: 1px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_listing4
//            {
//            }
//
//            .block_listing5
//            {
//            }
//
//            .block_info1
//            {
//            background-color: #8C0101;
//            width: 100%;
//            height: 100%;
//            font-size: 14px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_info2
//            {
//            }
//
//            .block_info3
//            {
//            }
//
//            .block_info4
//            {
//            }
//
//            .block_info5
//            {
//            }
//
//            .block_expandmain1
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #FFFFFF;
//            width: 100%;
//            height: 100%;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_expandmain2
//            {
//            }
//
//            .block_expandmain3
//            {
//            }
//
//            .block_expandmain4
//            {
//            }
//
//            .block_expandmain5
//            {
//            }
//
//            .block_expandtitle1
//            {
//            border-radius: 8px 8px 0px 0px;
//            -moz-border-radius: 8px 8px 0px 0px;
//            -webkit-border-radius: 8px 8px 0px 0px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 4px;
//            font-size: 14px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_expandtitle2
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 10px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_expandtitle3
//            {
//            }
//
//            .block_expandtitle4
//            {
//            }
//
//            .block_expandtitle5
//            {
//            }
//
//            .block_collapsetitle1
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 4px;
//            font-size: 14px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: center;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_collapsetitle2
//            {
//            border-radius: 8px 8px 8px 8px;
//            -moz-border-radius: 8px 8px 8px 8px;
//            -webkit-border-radius: 8px 8px 8px 8px;
//            background-color: #687C66;
//            width: 100%;
//            height: 100%;
//            padding: 2px;
//            font-size: 10px;
//            font-weight: normal;
//            color: #FFFFFF;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_collapsetitle3
//            {
//            }
//
//            .block_collapsetitle4
//            {
//            }
//
//            .block_collapsetitle5
//            {
//            }
//
//            .block_image1
//            {
//            }
//
//            .block_image2
//            {
//            }
//
//            .block_image3
//            {
//            }
//
//            .block_image4
//            {
//            }
//
//            .block_image5
//            {
//            }
//
//            .block_comment1
//            {
//            }
//
//            .block_comment2
//            {
//            }
//
//            .block_comment3
//            {
//            }
//
//            .block_comment4
//            {
//            }
//
//            .block_comment5
//            {
//            }
//
//            .block_priority1
//            {
//            }
//
//            .block_priority2
//            {
//            }
//
//            .block_priority3
//            {
//            }
//
//            .block_priority4
//            {
//            }
//
//            .block_priority5
//            {
//            }
//
//            .block_pagingnorm1
//            {
//            border: 1px solid;
//            border-color: #CCCCCC;
//            border-radius: 6px 6px 6px 6px;
//            -moz-border-radius: 6px 6px 6px 6px;
//            -webkit-border-radius: 6px 6px 6px 6px;
//            background-color: #FFFFFF;
//            width: 30px;
//            height: 100%;
//            padding: 4px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_pagingnorm2
//            {
//            }
//
//            .block_pagingnorm3
//            {
//            }
//
//            .block_pagingnorm4
//            {
//            }
//
//            .block_pagingnorm5
//            {
//            }
//
//            .block_paginghov1
//            {
//            border: 1px solid;
//            border-color: #8C0D1E;
//            border-radius: 6px 6px 6px 6px;
//            -moz-border-radius: 6px 6px 6px 6px;
//            -webkit-border-radius: 6px 6px 6px 6px;
//            background-color: #FFFFFF;
//            width: 30px;
//            height: 100%;
//            padding: 4px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_paginghov2
//            {
//            }
//
//            .block_paginghov3
//            {
//            }
//
//            .block_paginghov4
//            {
//            }
//
//            .block_paginghov5
//            {
//            }
//
//            .block_pagingact1
//            {
//            border: 1px solid;
//            border-color: #8C0D1E;
//            border-radius: 6px 6px 6px 6px;
//            -moz-border-radius: 6px 6px 6px 6px;
//            -webkit-border-radius: 6px 6px 6px 6px;
//            background-color: #8C0D1E;
//            width: 30px;
//            height: 100%;
//            padding: 4px;
//            font-size: 12px;
//            font-weight: normal;
//            color: #000000;
//            text-decoration: none;
//            text-align: left;
//            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';
//            }
//
//            .block_pagingact2
//            {
//            }
//
//            .block_pagingact3
//            {
//            }
//
//            .block_pagingact4
//            {
//            }
//
//            .block_pagingact5
//            {
//            }
//
//            .block_main1:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_main2:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_main3:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_main4:hover
//            {
//            }
//
//            .block_main5:hover
//            {
//            background-color: transparent;
//            }
//
//            .block_title1:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_title2:hover
//            {
//            background-color: #F2F2F2;
//            }
//
//            .block_title3:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_title4:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_title5:hover
//            {
//            }
//
//            .block_msg1:hover
//            {
//            background-color: #8C0101;
//            }
//
//            .block_msg2:hover
//            {
//            }
//
//            .block_msg3:hover
//            {
//            }
//
//            .block_msg4:hover
//            {
//            }
//
//            .block_msg5:hover
//            {
//            }
//
//            .block_error1:hover
//            {
//            }
//
//            .block_error2:hover
//            {
//            }
//
//            .block_error3:hover
//            {
//            }
//
//            .block_error4:hover
//            {
//            }
//
//            .block_error5:hover
//            {
//            }
//
//            .block_listing1:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_listing2:hover
//            {
//            background-color: #F2EDFF;
//            }
//
//            .block_listing3:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_listing4:hover
//            {
//            }
//
//            .block_listing5:hover
//            {
//            }
//
//            .block_info1:hover
//            {
//            background-color: #8C0101;
//            }
//
//            .block_info2:hover
//            {
//            }
//
//            .block_info3:hover
//            {
//            }
//
//            .block_info4:hover
//            {
//            }
//
//            .block_info5:hover
//            {
//            }
//
//            .block_expandmain1:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_expandmain2:hover
//            {
//            }
//
//            .block_expandmain3:hover
//            {
//            }
//
//            .block_expandmain4:hover
//            {
//            }
//
//            .block_expandmain5:hover
//            {
//            }
//
//            .block_expandtitle1:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_expandtitle2:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_expandtitle3:hover
//            {
//            }
//
//            .block_expandtitle4:hover
//            {
//            }
//
//            .block_expandtitle5:hover
//            {
//            }
//
//            .block_collapsetitle1:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_collapsetitle2:hover
//            {
//            background-color: #687C66;
//            }
//
//            .block_collapsetitle3:hover
//            {
//            }
//
//            .block_collapsetitle4:hover
//            {
//            }
//
//            .block_collapsetitle5:hover
//            {
//            }
//
//            .block_image1:hover
//            {
//            }
//
//            .block_image2:hover
//            {
//            }
//
//            .block_image3:hover
//            {
//            }
//
//            .block_image4:hover
//            {
//            }
//
//            .block_image5:hover
//            {
//            }
//
//            .block_comment1:hover
//            {
//            }
//
//            .block_comment2:hover
//            {
//            }
//
//            .block_comment3:hover
//            {
//            }
//
//            .block_comment4:hover
//            {
//            }
//
//            .block_comment5:hover
//            {
//            }
//
//            .block_priority1:hover
//            {
//            }
//
//            .block_priority2:hover
//            {
//            }
//
//            .block_priority3:hover
//            {
//            }
//
//            .block_priority4:hover
//            {
//            }
//
//            .block_priority5:hover
//            {
//            }
//
//            .block_pagingnorm1:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_pagingnorm2:hover
//            {
//            }
//
//            .block_pagingnorm3:hover
//            {
//            }
//
//            .block_pagingnorm4:hover
//            {
//            }
//
//            .block_pagingnorm5:hover
//            {
//            }
//
//            .block_paginghov1:hover
//            {
//            background-color: #FFFFFF;
//            }
//
//            .block_paginghov2:hover
//            {
//            }
//
//            .block_paginghov3:hover
//            {
//            }
//
//            .block_paginghov4:hover
//            {
//            }
//
//            .block_paginghov5:hover
//            {
//            }
//
//            .block_pagingact1:hover
//            {
//            background-color: #8C0D1E;
//            }
//
//            .block_pagingact2:hover
//            {
//            }
//
//            .block_pagingact3:hover
//            {
//            }
//
//            .block_pagingact4:hover
//            {
//            }
//
//            .block_pagingact5:hover
//            {
//            }   
//             </STYLE>';
?>
