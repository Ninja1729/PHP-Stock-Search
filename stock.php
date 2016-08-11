<!DOCTYPE>
<html>
    <head>
        <title>
            Stock page
        </title>
        <style>
        
        
        #stsrchdiv{
    margin-top: 50px;
}
#stsrchtbl{
    background-color: whitesmoke;
    border: 1px solid lightgrey;
    padding-bottom: 30px;
}

#stsrchtbl tr td{
    
}



#stocktbl{

    margin-top: 50px;    
    font: Arial, Helvetica, sans-serif;    
    border: 1px solid lavender;
    border-spacing: 0px;
    background-color: whitesmoke;  
}



.sttblclass tr:first-child td {
    font: 28px;
}

#error{
     margin-top: 75px;    
    font: Arial, Helvetica, sans-serif; 
    border-color: black;
    border: 1px solid grey;
    padding: 5px;
    background-color: ghostwhite;
    font-size: 24px;
    width: 800px;
    margin: auto;
    text-align: center;
   
}

.tbl1 tr td{

    padding-right: 3px;
    padding-top: 3px;
    padding-bottom: 3px;
    padding-left: 3px;
     border: 1px solid lavender;

}

.tbl1 td:first-child{
     background-color: whitesmoke;
     width:250px;
     font-weight: bold;
}

.tbl1 td:nth-child(2){
    background-color: ghostwhite;
    width:250px;
    
}

p{
    font-style: italic;
    font-size: 28px;
}

.tbl2 tr td{

   
    padding-top: 3px;
    padding-bottom: 3px;
    padding-left: 3px;
     border: 1px solid lightgrey;

}

.tbl2 tr:first-child td{
     
     font-weight: bold;
}

#imagesize{
    height: 12px;
    width: 12px;
}

#btn{
     border: 1px solid lightgrey;
    border-radius: 5px;
    background-color: white;
}
        
        
        </style>
        
    </head>
    <body>
        <script type="text/javascript">
            function resetip(){
                    
            }
        </script>
            <div align="center" id="stsrchdiv">
            <form name="stock" method="GET" action="stock.php">
                <table frame="box" id="stsrchtbl">
                    <tr id="stsrchtblhdr1"><td colspan="2" align="center" style="border-bottom: 1px solid lightgrey;"><p>Stock Search</p></td></tr>
                    
                    
                    <tr ><td align="right" style="padding-top: 20px;width:190px;">Company Name or Symbol: </td><td style="padding-top: 20px;width:220px;"><?php if  (!isset($_GET["clear"]) && isset($_GET["ipcompsym"])){
                    echo "<input type='text' id='ipid' name='ipcompsym' value='".$_GET["ipcompsym"]."' required><br>";
                    } else{
                    echo "<input type='text' id='ipid' name='ipcompsym' value='' required><br>";
                    }?></td></tr>
                    
                    <tr><td></td><td>
                        <input type = "submit" id="btn"  name="search" value="Search">
                        <input type = "submit" id="btn"  name="clear" value="Clear">
                        
                        
                        </td></tr>
                    
            <tr><td colspan="2" align="right" style="padding-right: 80px;"><a href="http://www.markit.com/product/markit-on-demand">Powered by Markit on Demand</a></td></tr>
                </table>
               
            </form>
                </div>
        
        
        <?php
            
             if (isset($_GET["sym"])) {
                 $json_url = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET["sym"];
                 $json = file_get_contents($json_url);
                 $json_data = json_decode($json, true);
                 if ($json_data["Status"] == "SUCCESS"){
                     
                    date_default_timezone_set("UTC");
                    $down_img = "http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
                    $up_img = "http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
                    echo "<table id='stocktbl' align='center' border='1' class='tbl1'>";
                    echo "<tr><td>Name</td><td align='center'>".$json_data["Name"]."</td></tr>";
                    echo "<tr><td>Symbol</td><td align='center'>".$json_data["Symbol"]."</td></tr>";
                    echo "<tr><td>Last Price</td><td align='center'>".$json_data["LastPrice"]."</td></tr>";
                    //Change
                    $chgval = $json_data["Change"];
                    if ($chgval < 0){
                        echo "<tr><td>Change</td><td align='center'>".round($chgval, 2)."<img src='".$down_img."' id = 'imagesize'/></td></tr>";        
                    }else if ($chgval > 0){
                        echo "<tr><td>Change</td><td align='center'>".round($chgval, 2)."<img src='".$up_img."' id = 'imagesize'/></td></tr>";
                    }else{
                        echo "<tr><td>Change</td><td align='center'>".round($chgval, 2)."</td></tr>";
                    }
                    //Change Percent
                    $chgval = round(($json_data["ChangePercent"]),2);
                    if ($chgval < 0){
                        echo "<tr><td>Change Percent</td><td align='center'>".$chgval."%<img src='".$down_img."' id = 'imagesize'/></td></tr>";    
                    }else if ($chgval > 0){
                        echo "<tr><td>Change Percent</td><td align='center'>".$chgval."%<img src='".$up_img."' id = 'imagesize'/></td></tr>";
                    }else{
                        echo "<tr><td>Change Percent</td><td align='center'>".$chgval."%</td></tr>";
                    }
                    echo "<tr><td>Timestamp</td><td align='center'>". date("Y-m-d H:i A e",strtotime($json_data["Timestamp"]))."</td></tr>";   
                    echo "<tr><td>Market Cap</td><td align='center'>".round($json_data["MarketCap"]/1000000000, 2)." B</td></tr>";
                    //Volume
                    echo "<tr><td>Volume</td><td align='center'>".number_format($json_data["Volume"])."</td></tr>"; 
                    $chgytd = $json_data["LastPrice"] - $json_data["ChangeYTD"];
                    if ($chgytd < 0){
                        echo "<tr><td>Change YTD</td><td align='center'>(".round($chgytd,2).")<img src='".$down_img."' id = 'imagesize'/></td></tr>";    
                    }else if ($chgytd > 0){
                        echo "<tr><td>Change YTD</td><td align='center'>".round($chgytd,2)."<img src='".$up_img."' id = 'imagesize'/></td></tr>";    
                    }else{
                        echo "<tr><td>Change YTD</td><td align='center'>".round($chgytd,2)."</td></tr>";
                    }
                    $chgval = round(($json_data["ChangePercentYTD"]),2);
                    if ($chgval < 0){
                        echo "<tr><td>Change Percent YTD</td><td align='center'>".$chgval."%<img src='".$down_img."' id = 'imagesize'/></td></tr>";   
                    }else if ($chgval > 0){
                        echo "<tr><td>Change Percent YTD</td><td align='center'>".$chgval."%<img src='".$up_img."' id = 'imagesize'/></td></tr>";
                    }else{
                        echo "<tr><td>Change Percent YTD</td><td align='center'>".$chgval."%</td></tr>";
                    }
                    echo "<tr><td>High</td><td align='center'>".$json_data["High"]."</td></tr>";
                    echo "<tr><td>Low</td><td align='center'>".$json_data["Low"]."</td></tr>";
                    echo "<tr><td>Open</td><td align='center'>".$json_data["Open"]."</td></tr>";
                    echo "</table>";
                    }else{
                        echo "<div id='error'>There is no stock information available</div>";
                    }
                 
                    }else if  (isset($_GET["ipcompsym"]) && isset($_GET["search"])){
                        $compsym = $_GET["ipcompsym"];
                        $map_url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".urlencode($compsym);
                        
                        if (($response_xml_data = file_get_contents($map_url))===false){
                            echo "Error fetching XML\n";
                        } else {
                            libxml_use_internal_errors(true);
                            $data = simplexml_load_string($response_xml_data);
                            if (!$data) {
                                echo "<div id='error'>No Records has been found</div>";
                                }
                            else {
                                echo "<table id='stocktbl' class='tbl2' align='center' border='1'><tr><td width='320'>Name</td><td width='80'>Symbol</td><td width='150'>Exchange</td><td width='120'>Detail</td></tr>";
                                foreach($data->LookupResult as $child){
     echo "<tr><td>".$child->Name."</td><td>".$child->Symbol."</td><td>".$child->Exchange."</td><td><a href='stock.php?ipcompsym=".$compsym."&sym=".$child->Symbol."'>More Details</a></td></tr>";
                                }
                            echo "</table>";
                            }
                        }
                    }
        
                         
                ?>
    </body>
</html>