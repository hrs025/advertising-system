<?php
require_once './connection.php';
require_once './head.php';
//print_r($_REQUEST);
?>

<!--Pincode-->

<?php
if(@$_REQUEST['tab']=="pincode")
{
    if(@$_REQUEST['delid']!="")
    {
        if($_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update delivery_pincode set pincode_status=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update delivery_pincode set pincode_status=1 where delivery_pincode_id='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from delivery_pincode where delivery_pincode=$_REQUEST[upval]");
        $upsel1=  mysqli_fetch_array($upsel);
        if(!$upsel1)
          { 
             $up=  mysqli_query($con,"update delivery_pincode set delivery_pincode=$_REQUEST[upval] where delivery_pincode_id='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Store</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Pincode Temporary?')){del('pincode','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Pincode</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from delivery_pincode d,servicesassign s where d.pincode_status=0 and d.assignid=s.assignid and s.userid='$_SESSION[user]' order by d.delivery_pincode_id desc limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select * from delivery_pincode d,servicesassign s where d.pincode_status=0 and d.assignid=s.assignid and s.userid='$_SESSION[user]' and d.delivery_pincode like '$_REQUEST[search]%' order by d.delivery_pincode_id desc limit $st,$pp");
        //$sel=  mysqli_query($con,"select * from city where citydel=0 and cityname like '$_REQUEST[search]%' order by cityname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td><?php echo $sel1['businessname']; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Pincode Temporary?')){del('pincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>');}"><input type="text" class="w3-input" style="text-align: center;" id="upin" onblur="update('pincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>',this.value);" value="<?php echo $sel1['delivery_pincode']; ?>" class="w3-input" /></td>
                <td><font><i class="fa fa-pencil" onclick="up('pincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
            <tr>
                <td><?php echo $sel1['businessname']; ?></td>
                <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Pincode Temporary?')){del('pincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>');}"><?php echo $sel1['delivery_pincode']; ?></td>
                <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('pincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>')"></i></font></td>
            </tr>
            <?php
            }
        }
       ?>
        <tr class="paging1">
            <td colspan="2">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(d.delivery_pincode_id) from delivery_pincode d,servicesassign s where d.pincode_status=0 and s.assignid=d.assignid and s.userid='$_SESSION[user]'");
                }
                else
                {
                     $t=  mysqli_query($con,"select count(d.delivery_pincode_id) from delivery_pincode d,servicesassign s where d.pincode_status=0 and s.assignid=d.assignid and s.userid='$_SESSION[user]' and delivery_pincode like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('pincode','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('pincode','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('pincode','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('pincode','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Pincode Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rpincode")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update delivery_pincode set pincode_status=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update delivery_pincode set pincode_status=0 where delivery_pincode_id='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from delivery_pincode where pincode_status=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from delivery_pincode where delivery_pincode_id='$_REQUEST[delid]'");
        }
    }

?>
     <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Store</th>
             <th>Pincode</th>
             <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All Pincode?')){restore('rpincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}">Restore</th>
             <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Pincode Permenant?')){delrecycle('rpincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from delivery_pincode d,servicesassign s where d.pincode_status=1 and d.assignid=s.assignid and s.userid='$_SESSION[user]' order by d.delivery_pincode_id desc limit $st,$pp");
            //$sel=  mysqli_query($con,"select * from city where citydel=1 order by cityname limit $st,$pp");
        }
        else 
        {
             $sel=  mysqli_query($con,"select * from delivery_pincode d,servicesassign s where d.pincode_status=1 and d.assignid=s.assignid and s.userid='$_SESSION[user]' and d.delivery_pincode like '$_REQUEST[search]%' order by d.delivery_pincode_id desc limit $st,$pp");
            //$sel=  mysqli_query($con,"select * from city where citydel=1 and cityname like '$_REQUEST[search]%' order by cityname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
            <td><?php echo $sel1['businessname']; ?></td>
           <td><?php echo $sel1['delivery_pincode'];?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Pincode?')){restore('rpincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Pincode Permenant?')){delrecycle('rpincode','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1['delivery_pincode_id']; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="3">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                   $t=  mysqli_query($con,"select count(d.delivery_pincode_id) from delivery_pincode d,servicesassign s where d.pincode_status=1 and s.assignid=d.assignid and s.userid='$_SESSION[user]'");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(d.delivery_pincode_id) from delivery_pincode d,servicesassign s where d.pincode_status=1 and s.assignid=d.assignid and s.userid='$_SESSION[user]' and delivery_pincode like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rpincode','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpincode','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpincode','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rpincode','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!-- size -->

<?php
if(@$_REQUEST['tab']=="size")
{
    if(@$_REQUEST['delid']!="")
    {
        if($_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"delete * from size");
        }
        else
        {
            $upone=  mysqli_query($con,"delete from size 
             where size_id='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select * from size where hight like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update size set size='$_REQUEST[upval]' where size_id='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Size Permenant?')){del('size','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Size ID</th>
            <th>Size</th>
            <th>Amount</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from size order by size_id limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from size where size like '$_REQUEST[search]%' order by size_id limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr><td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Size Permenant?')){del('size','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><?php  echo $sel1[0];?></td>
                <td><input type="text" class="w3-input" style="text-align: center;" id="upin" onblur="update('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>',this.value);" value="<?php echo $sel1[1]; ?>" class="w3-input" /></td>
                <td><input type="text" class="w3-input" style="text-align: center;" id="upin" onblur="update('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>',this.value);" value="<?php echo $sel1[2]; ?>" class="w3-input" /></td>
                <td><font><i class="fa fa-pencil" onclick="up('size','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
            <tr>
                <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Size Permenant?')){del('size','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><?php  echo $sel1[0];?></td>
                <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('size','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
            <?php
            }
        }
       ?>
        <tr class="paging1">
            <td colspan="2">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(size_id) from size");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(size_id) from size where size like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('size','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('size','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('size','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('size','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>




<!--City-->

<?php
if(@$_REQUEST['tab']=="city")
{
    if(@$_REQUEST['delid']!="")
    {
        if($_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update city set citydel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update city set citydel=1 where cityid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from city where cityname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update city set cityname='$_REQUEST[upval]' where cityid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All City Temporary?')){del('city','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">City</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from city where citydel=0 order by cityname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from city where citydel=0 and cityname like '$_REQUEST[search]%' order by cityname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete City Temporary?')){del('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><input type="text" class="w3-input" style="text-align: center;" id="upin" onblur="update('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>',this.value);" value="<?php echo $sel1[1]; ?>" class="w3-input" /></td>
                <td><font><i class="fa fa-pencil" onclick="up('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
            <tr>
                <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete City Temporary?')){del('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
                <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('city','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
            <?php
            }
        }
       ?>
        <tr class="paging1">
            <td colspan="2">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(cityid) from city where citydel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(cityid) from city where citydel=0 and cityname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('city','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('city','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('city','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('city','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--City Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rcity")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update city set citydel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update city set citydel=0 where cityid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from city where citydel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from city where cityid='$_REQUEST[delid]'");
        }
    }

?>
     <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
             <th>City</th>
             <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All City?')){restore('rcity','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}">Restore</th>
             <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All City Permenant?')){delrecycle('rcity','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from city where citydel=1 order by cityname limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select * from city where citydel=1 and cityname like '$_REQUEST[search]%' order by cityname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1];?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore City?')){restore('rcity','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete City Permenant?')){delrecycle('rcity','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="3">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(cityid) from city where citydel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(cityid) from city where citydel=1 and cityname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rcity','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rcity','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rcity','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rcity','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  

<!--Area-->

<?php
if(@$_REQUEST['tab']=="area")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update area set areadel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update area set areadel=1 where areaid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from area where areaname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
            
             $up=  mysqli_query($con,"update area set areaname='$_REQUEST[upval]' where areaid='$_REQUEST[updateid]'");
          }
          else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
 <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>City</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Area Temporary?')){del('area','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','deleteall');}">Area</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select areaname,cityname,areaid from area a,city c  where a.areadel=0 and c.cityid=a.cityid order by a.areaname limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select areaname,cityname,areaid from area a,city c where a.areadel=0 and c.cityid=a.cityid and a.areaname like '$_REQUEST[search]%' order by areaname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr>
                <td><?php echo $sel1[1]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Area Temporary?')){del('area','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><input type="text" class="w3-input" name="uparea" onblur="update('area','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[2]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[0]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
            <td><?php echo $sel1[1]; ?></td>
           <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Area Temporary?')){del('area','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('area','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="3">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(areaid) from area where areadel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(areaid) from area where areadel=0 and areaname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('area','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('area','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('area','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('area','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Area Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rarea")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update area set areadel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update area set areadel=0 where areaid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from area where areadel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from area where areaid='$_REQUEST[delid]'");
        }
    }

?>
    <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>City</th>
            <th>Area</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All Area?')){restore('rarea','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Area Permenant?')){delrecycle('rarea','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select areaname,cityname,areaid from area a,city c  where a.areadel=1 and c.cityid=a.cityid order by a.areaname limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select areaname,cityname,areaid from area a,city c where a.areadel=1 and c.cityid=a.cityid and a.areaname like '$_REQUEST[search]%' order by areaname limit $st,$pp"); 
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1]; ?></td>
           <td><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Area?')){restore('rarea','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Area Permenant?')){delrecycle('rarea','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(areaid) from area where areadel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(areaid) from area where areadel=1 and areaname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rarea','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rarea','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rarea','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rarea','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?> 

<!--Feedback-->


<?php
if(@$_REQUEST['tab']=="feedback")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $delall=mysqli_query($con,"delete from feedback");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from feedback where feedid='$_REQUEST[delid]'");
        }
    }
?>
<table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Feedback Permenant?')){del('feedback','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','deleteall');}">Name</th>
            <th>Message</th>
            <th>Feel</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from feedback order by feedname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from feedback where feedname like '$_REQUEST[search]%' order by feedname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Feedback?')){del('feedback','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1['feel']; ?></td>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td  colspan="2">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(feedid) from feedback");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(feedid) from feedback where feedname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('feedback','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if($_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('feedback','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('feedback','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('feedback','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Contact-->

<?php
if(@$_REQUEST['tab']=="contact")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $delall=mysqli_query($con,"delete from contact");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from contact where contactid='$_REQUEST[delid]'");
        }
    }
?>
<table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Contact Permenant?')){del('contact','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Name</th>
            <th>Mail</th>
            <th>Subject</th>
            <th>Message</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from contact order by contactname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from contact where contactname like '$_REQUEST[search]%' order by contactname limit $st,$pp");        
        }
        while(@$sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Contact?')){del('contact','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1['contact_subject']; ?></td>
                <td><?php echo $sel1[3]; ?></td>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="3">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(contactid) from contact");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(contactid) from contact where contactname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('contact','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('contact','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('contact','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('contact','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>


<!--User-->

<?php
if(@$_REQUEST['tab']=="user")
{
        if(@$_REQUEST['ek']=="ek")
        {
            $sel=  mysqli_query($con,"select *from registration where userid like '$_REQUEST[delid]'");
            $sel1=  mysqli_fetch_array($sel);
            $del1=  mysqli_query($con,"delete from emailsub where email like '$sel1[1]'");
            $del=  mysqli_query($con,"delete from registration where userid like '$_REQUEST[delid]'");
            
        }
        if(@$_REQUEST['ek']=="block")
        {
            $g1=  mysqli_query($con,"select * from registration where userid like '$_REQUEST[delid]'");
            $gg=  mysqli_fetch_array($g1);
            if($gg[6]==0)
            {
                $upone=  mysqli_query($con,"update registration set block=1 where userid like '$_REQUEST[delid]'");
            }
            else
            {
                $upone=  mysqli_query($con,"update registration set block=0 where userid like '$_REQUEST[delid]'");
            }   
            
        }
   

?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Name</th>
            <th>Mail</th>
            <th>Mobile</th>
            <th>User id</th>
            <th>Reg Date</th>
            <th>Profile</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from registration where type=2 order by email limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select * from registration where type=2 and username like '$_REQUEST[search]%' order by username limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Selected Customer?')){del('user','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[3]; ?>','ek');}"><?php echo $sel1[0]; ?></td>
               <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
               
                <td><?php echo $sel1[5]; ?></td>
                <td><img src="<?php echo $sel1[8]; ?>" style="width: 80px;height: 60px;text-align: center;" /></td>
                <?php
                if($sel1[6]==1)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i ondblclick="if(confirm('Are You Sure Want To Block Customer?')){del('user','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[3]; ?>','block');}" class="fa fa-circle"/></font></td>
                <?php
                }
                if($sel1[6]==0)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i ondblclick="if(confirm('Are You Sure Want To Active Selected Customer?')){del('user','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[3]; ?>','block');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="7">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(userid) from registration where type=2");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(userid) from registration where type=2 and username like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('user','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('user','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('user','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('user','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>


<!-- Manage Service Provider Review-->


<?php
if(@$_REQUEST['tab']=="review")
{
    if(@$_REQUEST['ek']=="ek")
    {
            $del=  mysqli_query($con,"delete from review where reviewid like $_REQUEST[delid]");
    }

    if(@$_REQUEST['ek']=="block")
    {
        $g1=  mysqli_query($con,"select * from review where reviewid like $_REQUEST[delid]");
        $gg=  mysqli_fetch_array($g1);
        if(@$gg[4]==0)
        {
                $upone=  mysqli_query($con,"update review set status=1 where reviewid like $_REQUEST[delid]");
        }
        else
        {
                $upone=  mysqli_query($con,"update review set status=0 where reviewid like $_REQUEST[delid]");
        }  
    }
   
?>
     <table class="table table-responsive comtab city">
         
         <th>Cover Pick</th>
        <th>Profile Pick</th>
        <th>Business</th>
        <th>User Name</th>
        <th>Review</th>
        <th>Date</th>
        <th>Status</th>
       
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
         $sel=  mysqli_query($con,"select r.*,s.businessname,s.coverpick,re.username,re.profile from review r,servicesassign s,registration re where s.assignid=r.assignid and re.userid=r.userid  order by re.username limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select r.*,s.businessname,s.coverpick,re.username,re.profile from review r,servicesassign s,registration re where s.assignid=r.assignid and re.userid=r.userid and re.username like '$_REQUEST[search]%' order by re.username limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr  style="font-size: 13px;text-transform: none;border-bottom: 1px dashed #01c38e;">
                
               <td><img src="<?php echo $sel1[7]; ?>" class="img img-responsive" style="width: 80px;height: 60px;"/></td>
               <td><img src="<?php echo $sel1[9]; ?>" style="width: 80px;height: 60px;;" /></td>
                <td><?php echo $sel1[6]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Selected User?')){del('review','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','ek');}"><?php echo $sel1[8]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
                <?php
                if($sel1[4]==1)
                {
                    ?>
                <td><font style="color: #01c38e;"><i ondblclick="if(confirm('Are You Sure Want To Block Review?')){del('review','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','block');}" class="fa fa-circle"/></font></td>
                <?php
                }
                if($sel1[4]==0)
                {
                    ?>
                <td><font style="color: #01c38e;"><i ondblclick="if(confirm('Are You Sure Want To Active Selected Review?')){del('review','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','block');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;text-align:center;" colspan="7">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(reviewid) from review");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(reviewid) from review where review='$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('review','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('review','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('review','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('review','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php

}
?>


<!-- Manage Product Review-->


<?php
if(@$_REQUEST['tab']=="productreview")
{
        if(@$_REQUEST['ek']=="ek")
        {
            $del=  mysqli_query($con,"delete from reviewproduct where reviewid like $_REQUEST[delid]");
        }
        if(@$_REQUEST['ek']=="block")
        {
            $g1=  mysqli_query($con,"select * from reviewproduct where reviewid like $_REQUEST[delid]");
            $gg=  mysqli_fetch_array($g1);
            if($gg[4]==0)
            {
                    $upone=  mysqli_query($con,"update reviewproduct set status=1 where reviewid like $_REQUEST[delid]");
            }
            else
            {
                    $upone=  mysqli_query($con,"update reviewproduct set status=0 where reviewid like $_REQUEST[delid]");
            }   
            
        }
   

?>
     <table class="table table-responsive comtab city">
         
         <th>Product Pic</th>
        <th>Profile Pick</th>
        <th>Product Name</th>
        <th>User Name</th>
        <th>Review</th>
        <th>Date</th>
        <th>Status</th>
       
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
                $sel=  mysqli_query($con,"select r.*,ps.petasubcatname,p.imagepath,re.username,re.profile from reviewproduct r,petasubcategory ps,registration re,productmaster p where ps.petasubcatid=p.petasubcatid and re.userid=r.userid and p.productid=r.productid order by re.username limit $st,$pp");
        }
        else
        {
                $sel=  mysqli_query($con,"select r.*,ps.petasubcatname,p.imagepath,re.username,re.profile from reviewproduct r,petasubcategory ps,registration re,productmaster p where ps.petasubcatid=p.petasubcatid and re.userid=r.userid and p.productid=r.productid and re.username like '$_REQUEST[search]%' order by re.username limit $st,$pp");   
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr  style="font-size: 13px;text-transform: none;border-bottom: 1px dashed #01c38e;">
                
               <td><img src="<?php echo $sel1[7]; ?>" style="width: 80px;height: 60px;" class="img img-responsive" /></td>
               <td><img src="<?php echo $sel1[9]; ?>" style="width: 80px;height: 60px;" class="img img-responsive" /></td>
                <td><?php echo $sel1[6]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Selected User Review?')){del('productreview','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','ek');}"><?php echo $sel1[8]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
                <?php
                if($sel1[4]==1)
                {
                    ?>
                <td><font style="color: #01c38e;"><i ondblclick="if(confirm('Are You Sure Want To Block Review?')){del('productreview','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','block');}" class="fa fa-circle"/></font></td>
                <?php
                }
                if($sel1[4]==0)
                {
                    ?>
                <td><font style="color: #01c38e;"><i ondblclick="if(confirm('Are You Sure Want To Active Selected Review?')){del('productreview','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>','<?php echo $sel1[0]; ?>','block');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;text-align:center;" colspan="7">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(reviewid) from reviewproduct");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(reviewid) from reviewproduct where review='$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('productreview','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('productreview','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('productreview','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('productreview','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>


<!-- Manage Inquiry Form Service Provider-->


<?php
if(@$_REQUEST['tab']=="inquiry")
{
  
    if(@$_REQUEST['delid']!="")
    {
        $del=  mysqli_query($con,"delete from inquiry where inquiryid like $_REQUEST[delid]");

    }
   

?>
     <table class="table table-responsive comtab city">
         
         <th>Product Pic</th>
        <th>Product Name</th>
        <th>Contact Name</th>
        <th>Email</th>
        <th>Message</th>

       
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $a=  mysqli_query($con,"select *from servicesassign where serviceid=19 and userid like '$_SESSION[user]'");
            $a1=  mysqli_fetch_array($a);
            $sel=  mysqli_query($con,"select i.*,p.imagepath,ps.petasubcatname from inquiry i,productmaster p,petasubcategory ps  where p.productid=i.productid and ps.petasubcatid=p.petasubcatid and i.assignid=$a1[0] order by i.name limit $st,$pp");
         
        }
        else
        {
           $sel=  mysqli_query($con,"select i.*,p.imagepath,ps.petasubcatname from inquiry i,productmaster p,petasubcategory ps  where p.productid=i.productid and ps.petasubcatid=p.petasubcatid and i.assignid=$a1[0] and i.name like '$_REQUEST[search]%' order by i.name limit $st,$pp");
            
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr  style="font-size: 13px;text-transform: none;border-bottom: 1px dashed #01c38e;">
                
               <td><img src="<?php echo $sel1[6]; ?>" style="width: 80px;height: 60px;" /></td>
               <td><?php echo $sel1[7]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Selected Contact?')){del('inquiry','<?php echo $_REQUEST["p"]; ?>','<?php echo $_REQUEST["pp"]; ?>',<?php echo $sel1[0]; ?>);}"><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[4]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
             
            </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;text-align:center;" colspan="5">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(inquiryid) from inquiry");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(inquiryid) from inquiryid where name like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('inquiry','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('inquiry','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('inquiry','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('inquiry','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>


<!-- Service Provider -->

<?php
if(@$_REQUEST['tab']=="servicep")
{
        if(@$_REQUEST['ek']=="ek")
        {
            $sel=  mysqli_query($con,"select *from registration where userid like '$_REQUEST[delid]'");
            $sel1=  mysqli_fetch_array($sel);
            $del1=  mysqli_query($con,"delete from emailsub where email like '$sel1[1]'");
            $del=  mysqli_query("delete from registration where userid like '$_REQUEST[delid]'");
            
        }
        if(@$_REQUEST['ek']=="block")
        {
            $g1=  mysqli_query($con,"select * from registration where userid like '$_REQUEST[delid]'");
            $gg=  mysqli_fetch_array($g1);
            if($gg[6]==0)
            {
                $upone=  mysqli_query($con,"update registration set block=1 where userid like '$_REQUEST[delid]'");
            }
            else
            {
                $upone=  mysqli_query($con,"update registration set block=0 where userid like '$_REQUEST[delid]'");
            }   
            
        }
   

?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Name</th>
            <th>Mail</th>
            <th>Mobile</th>
            <th>User id</th>
            <th>Reg Date</th>
            <th>Profile</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from registration where type=1 order by email limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select * from registration where type=1 and username like '$_REQUEST[search]%' order by username limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Selected Seller?')){del('servicep','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[3]; ?>','ek');}"><?php echo $sel1[0]; ?></td>
               <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
               
                <td><?php echo $sel1[5]; ?></td>
                <td><img src="<?php echo $sel1[8]; ?>" style="width: 80px;height: 60px;text-align: center;" /></td>
                <?php
                if($sel1[6]==1)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i ondblclick="if(confirm('Are You Sure Want To Block Selected Seller?')){del('servicep','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[3]; ?>','block');}" class="fa fa-circle"/></font></td>
                <?php
                }
                if($sel1[6]==0)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i ondblclick="if(confirm('Are You Sure Want To Active Selected Seller?')){del('servicep','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[3]; ?>','block');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="7">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(userid) from registration where type=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(userid) from registration where username like '$_REQUEST[search]%' and type=1");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('servicep','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('servicep','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('servicep','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('servicep','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Admin Side Product -->

<?php
if(@$_REQUEST['tab']=="product")
{
    if(@$_REQUEST['delid']!="")
    {
            $g1=  mysqli_query($con,"select * from productmaster where productid like $_REQUEST[delid]");
            $gg=  mysqli_fetch_array($g1);
            if($gg[8]==0)
            {
                $upone=  mysqli_query($con,"update productmaster set verify=1 where productid like $_REQUEST[delid]");
            }
            else
            {
                $upone=  mysqli_query($con,"update productmaster set verify=0 where productid like $_REQUEST[delid]");
            }   
    }
   

?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
             <th>Store</th>
            <th>Main Category</th>
            <th>Sub</th>
            <th>Peta Sub</th>
            <th>Brand</th>
            <th>Measure</th>
            <th>Price<br/>(Rs)</th>
            <th>Dis.(Rs)</th>
            <th>Qty</th>
            <th>M Date</th>
            <th>E Date</th>
            <th>Manufacture Location</th>
            <th>Product Image</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid,discount,qty from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid order by pr.productid desc limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid,discount,qty from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and m.maincatname like '$_REQUEST[search]%' order by m.maincatname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td><?php echo $sel1[0]; ?></td>
               <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[4]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
                <td><?php echo $sel1[6]; ?></td>
                <td><?php echo $sel1[14]; ?></td>
                <td><?php echo $sel1[15]; ?></td>
                <td><?php echo $sel1[7]; ?></td>
                <td><?php echo $sel1[8]; ?></td>
                <td><?php echo $sel1[9]; ?></td>
                <td><img src="<?php echo $sel1[11]; ?>" style="width: 80px;height: 60px;" /></td>
                <?php
                if($sel1[12]==1)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i title="Active Product" ondblclick="if(confirm('Are You Sure Want To Block Product?')){del('product','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}" class="fa fa-circle"/></font></td>
                <?php
                }
                if($sel1[12]==0)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i title="Not Verified Product" ondblclick="if(confirm('Are You Sure Want To Active Selected Product?')){del('product','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="13">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(productid) from productmaster");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(productid) from productmaster p,maincategory m where p.maincatid=m.maincatid and m.maincatname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('product','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('product','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('product','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('product','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!-- Service Provider Side Product-->


<?php
if(@$_REQUEST['tab']=="productsp")
{
    if(@$_REQUEST['delid']!="")
    {
        if($_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update productmaster set productdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update productmaster set productdel=1 where productid='$_REQUEST[delid]'");
        }
    }
?>
<form action="" method="post" class="profileedit form-group" name="product" id="mydata">
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Store</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Product?')){del('productsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp0']; ?>','deleteall');}">Main Category</th>
            <th>Sub</th>
            <th>Peta Sub</th>
            <th>Brand</th>
            <th>Measure</th>
            <th>Price<br/>(Rs)</th>
            <th>Dis.(Rs)</th>
            <th>Qty</th>
            <th>M Date</th>
            <th>E Date</th>
            <th>Manufacture Location</th>
            <th>Product Image</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;

        $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid,discount,qty from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and pr.productdel=0 and sa.userid like '$_SESSION[user]' order by pr.productid desc limit $st,$pp");

        if($_REQUEST['search']!="")
        {
         $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid,discount,qty from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and pr.productdel=0 and pc.petasubcatname like '%$_REQUEST[search]%' and sa.userid like '$_SESSION[user]' order by pr.productid desc limit $st,$pp");
        }


        if(@$_REQUEST['qty']!=0)
        {
         $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid,discount,qty from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and pr.productdel=0 and pr.qty <= $_REQUEST[qty] and sa.userid like '$_SESSION[user]' order by pr.productid desc limit $st,$pp");
        }
               
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[13])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Product Temporary?')){del('productsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}"><input type="text" style="text-align: center;" id="upin" name="uppackage" value="<?php echo $sel1[1]; ?>" /></td>
                <td><input class="w3-input" type="text" style="text-align: center;" name="uppackduration" value="<?php echo $sel1[2]; ?>"/></td>
                <td><input class="w3-input" type="text" style="text-align: center;" name="uppackprice" value="<?php echo $sel1[3]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" onclick="updatemulti('productsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
               <td><?php echo $sel1[0]; ?></td>
               <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[4]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
                <td><?php echo $sel1[6]; ?></td>
                <td><?php echo $sel1[14]; ?></td>
                <td><?php echo $sel1[15]; ?></td>
                <td><?php echo $sel1[7]; ?></td>
                <td><?php echo $sel1[8]; ?></td>
                <td><?php echo $sel1[9]; ?></td>
                <td><img src="<?php echo $sel1[11]; ?>" style="width: 100%;text-align: center;" /></td>
                <td><i class="fa fa-remove" ondblclick="if(confirm('Are You Sure Want To Delete Product?')){del('productsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}"></i></td>
                <td><font><a class="w3-button" href="edit-product.php?productid=<?php echo $sel1[13]; ?>"><i class="fa fa-pencil" style="cursor: pointer;"></i></a></font></td>
                <td>
                    <?php
                    if($sel1[12]==1)
                    {
                        echo "<font title='Active Product' style='color:#4E75F3;'><b>Active</b></font>";
                    }
                    else
                    {
                         echo "<font title='De-active Product' style='color:red;'><b>Deactive</b></font>";
                    }
                    ?>
                </td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="14">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;

                $t=  mysqli_query($con,"select count(p.productid) from productmaster p,servicesassign sa where p.productdel=0 and sa.userid like '$_SESSION[user]' and sa.assignid=p.assignid");
                if($_REQUEST['search']!="")
                {
                    $t=  mysqli_query($con,"select count(p.productid) from productmaster p,servicesassign sa,maincategory m where p.productdel=0 and sa.userid like '$_SESSION[user]' and sa.assignid=p.assignid and m.maincatid=p.maincatid and m.maincatname like '$_REQUEST[search]%'");
                }
                if($_REQUEST['qty']!=0)
                {
                    $t=  mysqli_query($con,"select count(p.productid) from productmaster p,servicesassign sa,maincategory m where p.productdel=0 and sa.userid like '$_SESSION[user]' and sa.assignid=p.assignid and m.maincatid=p.maincatid and p.qty <= $_REQUEST[qty]");
                }
                $tt=  mysqli_fetch_array($t);


                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('productsp','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('productsp','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('productsp','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('productsp','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--Service Provider Product Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rproductsp")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update productmaster set productdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update productmaster set productdel=0 where productid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $sel=  mysqli_query($con,"select *from productmaster where productdel=1");
            $sel1=  mysqli_fetch_array($sel);
            unlink($sel1[13]);
            $delall=  mysqli_query($con,"delete from productmaster where productdel=1");
        }
        else
        {
            $sel=  mysqli_query($con,"select *from productmaster where productid='$_REQUEST[delid]'");
            $sel1=  mysqli_fetch_array($sel);
            unlink($sel1[13]);
            $delone=  mysqli_query($con,"delete from productmaster where productid='$_REQUEST[delid]'");
        }
    }

?>
     <table class="table table-responsive comtab cityrecyclebin">
         <th>Business</th>
        <th>Main Category</th>
        <th>Sub Category</th>
        <th>Peta Sub Category</th>
        <th>Company</th>
        <th>Measure</th>
        <th>Price</th>
        <th>M Date</th>
        <th>E Date</th>
        <th>M Location</th>
        <th>Product Image</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Product?')){restore('rproductsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Product Permenant?')){delrecycle('rproductsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and pr.productdel=1 and sa.userid like '$_SESSION[user]' order by m.maincatname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select businessname,maincatname,subcatname,petasubcatname,companyname,measure,price,mdate,edate,mlocation,description,imagepath,verify,productid from servicesassign sa,maincategory m,subcategory s,petasubcategory pc,company c,measure me,productmaster pr where sa.assignid=pr.assignid and m.maincatid=pr.maincatid and s.subcatid=pr.subcatid and pc.petasubcatid=pr.petasubcatid and c.companyid=pr.companyid and me.measureid=pr.measureid and pr.productdel=1 and m.maincatname like '$_REQUEST[search]%' and sa.userid like '$_SESSION[user]' order by m.maincatname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
            <td><?php echo $sel1[0]; ?></td>
            <td><?php echo $sel1[1]; ?></td>
            <td><?php echo $sel1[2]; ?></td>
            <td><?php echo $sel1[3]; ?></td>
            <td><?php echo $sel1[4]; ?></td>
            <td><?php echo $sel1[5]; ?></td>
            <td><?php echo $sel1[6]; ?></td>
            <td><?php echo $sel1[7]; ?></td>
            <td><?php echo $sel1[8]; ?></td>
            <td><?php echo $sel1[9]; ?></td>
            <td><img src="<?php echo $sel1[11]; ?>" style="width: 30%;text-align: center;" /></td>
           
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Product?')){restore('rproductsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Product Permenant?')){delrecycle('rproductsp','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[13]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="14">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(p.productid) from productmaster p,servicesassign s where p.productdel=1 and s.userid like '$_SESSION[user]' and s.assignid=p.assignid");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(productid) from productmaster where productdel=1 and measurename like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rproductsp','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rproductsp','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rproductsp','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rproductsp','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  


<!--Email Subscribel-->

<?php
 
if(@$_REQUEST['tab']=="emailsub")
{
   
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $delall=mysqli_query($con,"delete from emailsub");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from emailsub where emailsubid='$_REQUEST[delid]'");
        }
    }
?>
 
<form>
     <table class="table table-responsive comtab city">
        <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Email Permenant?')){del('emailsub','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Email</th>
      <?php
      if(@$_REQUEST['delid']=="checkall")
      {
          ?>
        <th id="selectall" onclick="del('emailsub','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','');" style="cursor: pointer;">Deselect All&nbsp;</th>
      <?php  
      }
      else
      {
      ?>
        <th id="selectall" onclick="del('emailsub','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','checkall');" style="cursor: pointer;">Select All&nbsp;</th>
      <?php
      }
      ?>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from emailsub order by email limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from emailsub where email like '$_REQUEST[search]%' order by email limit $st,$pp");        
        }
        
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
        
            <tr style="font-size: 13px;text-transform: none;border-bottom: 1px dashed #01c38e;">
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Email Temporary?')){del('emailsub','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
                <?php
                if(@$_REQUEST['delid']=='checkall')
                {
                ?>
                <td><input type="checkbox" name="emailsel" checked=""></td>
                <?php
                }
                else
                {
                ?>    
                
                <td><input type="checkbox" name="emailsel" ></td>
                <?php
                }
                ?>
            </tr>
        
        <?php
         }
       ?>
         <tr>
            <td style="background: #01c38e;text-align:center;" colspan="2">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(emailsubid) from emailsub");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(emailsubid) from emailsub where email like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('emailsub','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('emailsub','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('emailsub','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('emailsub','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
    </form>
<?php
}
?>


<!--Services -->

<?php
if(@$_REQUEST['tab']=="service")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update services set servicedel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update services set servicedel=1 where serviceid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from services where servicename like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update services set servicename='$_REQUEST[upval]' where serviceid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Services Temporary?')){del('service','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Services</th>
            <th>Services Images</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from services where servicedel=0 order by servicename limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from services where servicedel=0 and servicename like '$_REQUEST[search]%' order by servicename limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Service Temporary?')){del('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input type="text" class="w3-input" style="text-align: center;" id="upin" onblur="update('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>',this.value);" value="<?php echo $sel1[1]; ?>"/></td>
                <td><input type="file" class="w3-input" style="text-align: center;" id="upin" onblur="update('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>',this.value);" value="<?php echo $sel1[3]; ?>"/></td>
                <td><font><i class="fa fa-pencil" onclick="up('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
           <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Service Temporary?')){del('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><img src="<?php echo $sel1[3];  ?>" style="width: 80px;height: 60px;"/></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('service','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(serviceid) from services where servicedel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(serviceid) from services where servicedel=0 and servicename like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('service','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('service','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('service','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('service','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Services recyclebin-->

<?php
if(@$_REQUEST['tab']=="rservice")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update services set servicedel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update services set servicedel=0 where serviceid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $getpath=  mysqli_query($con,"selevct *from services where servicedel=1");
            $path=  mysqli_fetch_array($getpath);
            unlink($path[3]);
            $delall=  mysqli_query($con,"delete from services where servicedel=1");
        }
        else
        {
            $getpath=  mysqli_query($con,"select *from services where serviceid='$_REQUEST[delid]'");
            $path=  mysqli_fetch_array($getpath);
            unlink($path[3]);
            $delone=  mysqli_query($con,"delete from services where serviceid='$_REQUEST[delid]'");
        }
    }

?>
<table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Service</th>
            <th>Service images</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All Services?')){restore('rservice','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Services Permenant?')){delrecycle('rservice','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from services where servicedel=1 order by servicename limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select * from services where servicedel=1 and servicename like '$_REQUEST[search]%' order by servicename limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1];?></td>
           <td><img src="<?php echo $sel1[3];?>" style="width: 80px;height: 60px;" /></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Service?')){restore('rservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Service Permenant?')){delrecycle('rservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(serviceid) from services where servicedel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(serviceid) from services where servicedel=1 and servicename like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rservice','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rservice','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  

<!--Sub Services-->

<?php
if(@$_REQUEST['tab']=="subservice")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update subservices set subservicedel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update subservices set subservicedel=1 where subserviceid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from subservices where subservicename like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
            
             $up=  mysqli_query($con,"update subservices set subservicename='$_REQUEST[upval]' where subserviceid='$_REQUEST[updateid]'");
          }
          else
          {
              echo "<font style='color:red;'>Already Exist</font>";
          }

    }
?>
     <table class="table table-responsive comtab city">
         <th>Service</th>
        <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Sub Services Temporary?')){del('subservice','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Sub Service</th>
        <th>Update</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if($_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select subservicename,servicename,subserviceid from subservices sb,services s  where sb.subservicedel=0 and sb.serviceid=s.serviceid order by sb.subservicename limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select subservicename,servicename,subserviceid from subservices sb,services s  where sb.subservicedel=0 and sb.serviceid=s.serviceid and sb.subservicename like '$_REQUEST[search]%' order by sb.subservicename limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr style="font-size: 13px;">
                <td><?php echo $sel1[1]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Sub Service Temporary?')){del('subservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input type="text" name="upsubservice" onblur="update('subservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[0]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
            <td><?php echo $sel1[1]; ?></td>
           <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Sub Service Temporary?')){del('subservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('subservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="3">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if($_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(subserviceid) from subservices where subservicedel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(subserviceid) from subservices where subservicedel=0 and subservicename like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('subservice','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('subservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('subservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('subservice','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Sub Services Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rsubservice")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update subservices set subservicedel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update subservices set subservicedel=0 where subserviceid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $getpath=  mysqli_query($con,"select *from subservices where subservicedel=1");
            $path=  mysqli_fetch_array($getpath);
            $delall=  mysqli_query($con,"delete from subservices where subservicedel=1");
        }
        else
        {
            $getpath=  mysqli_query($con,"select *from subservices where subserviceid='$_REQUEST[delid]'");
            $path=  mysqli_fetch_array($getpath);
            $delone=  mysqli_query($con,"delete from subservices where subserviceid='$_REQUEST[delid]'");
        }
    }

?>
     <table class="table table-responsive comtab cityrecyclebin">
         <th>Service</th>
         <th>Sub Service</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All Sub Services?')){restore('rsubservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Sub Services Permenant?')){delrecycle('rsubservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select subservicename,servicename,subserviceid from subservices sb,services s  where sb.subservicedel=1 and s.serviceid=sb.serviceid order by sb.subservicename limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select subservicename,servicename,subserviceid from subservices sb,services s where sb.subservicedel=1 and sb.serviceid=s.serviceid and sb.subservicename like '$_REQUEST[search]%' order by sb.subservicename limit $st,$pp"); 
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
           <td><?php echo $sel1[1]; ?></td>
           <td><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Sub Service?')){restore('rsubservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Sub Service Permenant?')){delrecycle('rsubservice','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="4">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(subserviceid) from subservices where subservicedel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(subserviceid) from subservices where subservicedel=1 and subservicename like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rsubservice','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rsubservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rsubservice','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rsubservice','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?> 



<!--Skill-->

<?php
if(@$_REQUEST['tab']=="skill")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update skill set skilldel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update skill set skilldel=1 where skillid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from skill where skillname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
            
             $up=  mysqli_query($con,"update skill set skillname='$_REQUEST[upval]' where skillid='$_REQUEST[updateid]'");
          }
          else
          {
              echo "<font style='color:red;'>Already Exist</font>";
          }

    }
?>
     <table class="table table-responsive comtab city">
         <th> Sub Service</th>
        <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Skill Temporary?')){del('skill','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Skill</th>
        <th>Update</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select skillname,subservicename,skillid from skill sk,subservices sb  where sk.skilldel=0 and sk.subserviceid=sb.subserviceid order by sk.skillname limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select skillname,subservicename,skillid from skill sk,subservices sb  where sk.skilldel=0 and sk.subserviceid=sb.subserviceid and sk.skillname like '$_REQUEST[search]%' order by sk.skillname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr style="font-size: 13px;">
                <td><?php echo $sel1[1]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Skill Temporary?')){del('skill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input type="text" name="upskill" onblur="update('skill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[0]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
            <td><?php echo $sel1[1]; ?></td>
           <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Skill Temporary?')){del('skill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('skill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="3">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(skillid) from skill where skilldel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(skillid) from skill where skilldel=0 and skillname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('skill','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('skill','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('skill','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('skill','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>

<!--Skill Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rskill")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update skill set skilldel=0");
        }
        else
        {
            $upone=  mysqli_query("$con,update skill set skilldel=0 where skillid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from skill where skilldel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from skill where skillid='$_REQUEST[delid]'");
        }
    }

?>
     <table class="table table-responsive comtab cityrecyclebin">
         <th>Sub Service</th>
         <th>Skill</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Resore All Skill?')){restore('rskill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Skill Permenant?')){delrecycle('rskill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select skillname,subservicename,skillid from skill sk,subservices sb  where sk.skilldel=1 and sb.subserviceid=sk.subserviceid order by sk.skillname limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select skillname,subservicename,skillid from skill sk,subservices sb  where sk.skilldel=1 and sb.subserviceid=sk.subserviceid and sk.skillname like '$_REQUEST[search]%' order by sk.skillname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
           <td><?php echo $sel1[1]; ?></td>
           <td><?php echo $sel1[0]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Skill?')){restore('rskill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Skill Permenant?')){delrecycle('rskill','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="4">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(skillid) from skill where skilldel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(skillid) from skill where skilldel=1 and skillname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rskill','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rskill','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rskill','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rskill','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?> 



<!--Package-->

<?php
if(@$_REQUEST['tab']=="package")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update package set packagedel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update package set packagedel=1 where packageid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['upmulid']!="")
    {
        $upsel=  mysqli_query($con,"select *from package where packagename like '$_REQUEST[uppackage]' and packageid!=$_REQUEST[upmulid]");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1)
          { 
             $up=  mysqli_query($con,"update package set packagename='$_REQUEST[uppackage]' where packageid='$_REQUEST[upmulid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
<form action="" method="post" class="profileedit form-group" name="package" id="mydata">
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Package Temporary?')){del('package','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Package</th>
            <th>Edit</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from package where packagedel=0 order by packageid desc limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from package where packagedel=0 and packagename like '$_REQUEST[search]%' order by packageid desc limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Package Temporary?')){del('package','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input class="w3-input" type="text" id="upin" name="uppackage" value="<?php echo $sel1[1]; ?>" /></td>
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" onclick="updatemulti('package','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
           <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Package Temporary?')){del('package','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('package','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(packageid) from package where packagedel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(packageid) from package where packagedel=0 and packagename like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('package','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('package','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('package','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('package','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--Package Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rpackage")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update package set packagedel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update package set packagedel=0 where packageid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from package where packagedel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from package where packageid='$_REQUEST[delid]'");
        }
    }

?>
    <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
         <th>Package</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Package?')){restore('rpackage','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Package Permenant?')){delrecycle('rpackage','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from package where packagedel=1 order by packageid desc limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select * from package where packagedel=1 and packagename like '$_REQUEST[search]%' order by packageid desc limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1];?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Package?')){restore('rpackage','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Package Permenant?')){delrecycle('rpackage','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(packageid) from package where packagedel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(packageid) from package where packagedel=1 and packagename like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rpackage','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpackage','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpackage','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rpackage','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  




<!--Main Category-->

<?php
if(@$_REQUEST['tab']=="maincategory")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update maincategory set maincatdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update maincategory set maincatdel=1 where maincatid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from maincategory where maincatname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update maincategory set maincatname='$_REQUEST[upval]' where maincatid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
<form action="" method="post" name="maincategory" id="maincategorydata">
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Main Category Temporary?')){del('maincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">Main Category Name</th>
            <th>Update</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from maincategory where maincatdel=0 order by maincatname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from maincategory where maincatdel=0 and maincatname like '$_REQUEST[search]%' order by maincatname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete maincategory Temporary?')){del('maincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input class="w3-input" type="text" style="text-align: center;" id="upin" name="upmaincategory" onchange="update('maincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>',this.value)" value="<?php echo $sel1[1]; ?>" /></td>
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
           <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Main Category Temporary?')){del('maincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('maincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(maincatid) from maincategory where maincatdel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(maincatid) from maincategory where maincatdel=0 and maincatname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('maincategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('maincategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('maincategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('maincategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--Main Category Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rmaincategory")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update maincategory set maincatdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update maincategory set maincatdel=0 where maincatid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $getpath=  mysqli_query($con,"select *from maincategory where maincatdel=1");
            $path=  mysqli_fetch_array($getpath);
            $delall=  mysqli_query($con,"delete from maincategory where maincatdel=1");
        }
        else
        {
            $getpath=  mysqli_query($con,"select *from maincategory where maincatid='$_REQUEST[delid]'");
            $path=  mysqli_fetch_array($getpath);
            $delone=  mysqli_query($con,"delete from maincategory where maincatid='$_REQUEST[delid]'");
        }
    }

?>
<table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
              <th>Main Category</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All maincategory?')){restore('rmaincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All maincategory Permenant?')){delrecycle('rmaincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        </tr>
       
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from maincategory where maincatdel=1 order by maincatname limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select * from maincategory where maincatdel=1 and maincatname like '$_REQUEST[search]%' order by maincatname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1];?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Main Category?')){restore('rmaincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Main Category Permenant?')){delrecycle('rmaincategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(maincatid) from maincategory where maincatdel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(maincatid) from maincategory where maincatdel=1 and maincatname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rmaincategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rmaincategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rmaincategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rmaincategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  





<!--Sub Category-->

<?php
//print_r($_REQUEST);
if(@$_REQUEST['tab']=="subcategory")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update subcategory set subcatdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update subcategory set subcatdel=1 where subcatid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from subcategory where subcatname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update subcategory set subcatname='$_REQUEST[upval]' where subcatid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
<form action="" method="post" name="subcategory" id="maincategorydata">
     <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
             <th>Main Category Name</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Sub Category Temporary?')){del('subcategory','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','deleteall');}">Sub Category Name</th>
            <th>Update</th>
        </tr> 
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select maincatname,subcatname,subcatid from subcategory sc,maincategory mc where sc.subcatdel=0 and sc.maincatid=mc.maincatid  order by sc.subcatname limit $st,$pp");
        
        }
        else
        {
        $sel=  mysqli_query($con,"select maincatname,subcatname,subcatid from subcategory sc,maincategory mc where sc.subcatdel=0 and sc.maincatid=mc.maincatid and sc.subcatname like '$_REQUEST[search]%' order by sc.subcatname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr>
                <td><?php echo $sel1[0]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Subcategory Temporary?')){del('subcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><input class="w3-input" type="text" style="text-align: center;" id="upin" onchange="update('subcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',this.value)" name="upsubcategory" value="<?php echo $sel1[1]; ?>" /></td>
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" ></i></font></td>
            </tr> 
        <?php
            }
            else
            {
          ?>
        <tr>
            <td><?php echo $sel1[0]; ?></td>
            <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Subcategory Temporary?')){del('subcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('subcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(subcatid) from subcategory where subcatdel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(subcatid) from subcategory where subcatdel=0 and subcatname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('subcategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('subcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('subcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('subcategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--Sub Category Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rsubcategory")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update subcategory set subcatdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update subcategory set subcatdel=0 where subcatid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $getpath=  mysqli_query($con,"select *from subcategory where subcatdel=1");
            $path=  mysqli_fetch_array($getpath);
            $delall=  mysqli_query($con,"delete from subcategory where subcatdel=1");
        }
        else
        {
            $getpath=  mysqli_query($con,"select *from subcategory where subcatid='$_REQUEST[delid]'");
            $path=  mysqli_fetch_array($getpath);
            $delone=  mysqli_query($con,"delete from subcategory where subcatid='$_REQUEST[delid]'");
        }
    }

?>
    <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Main Category Name</th>
            <th>Sub Category Name</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Subcategory?')){restore('rsubcategory','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Subcategory Permenant?')){delrecycle('rsubcategory','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
         $sel=  mysqli_query($con,"select maincatname,subcatname,subcatid from subcategory sc,maincategory mc where sc.subcatdel=1 and sc.maincatid=mc.maincatid  order by sc.subcatname limit $st,$pp");
        
        }
        else
        {
        $sel=  mysqli_query($con,"select maincatname,subcatname,subcatid from subcategory sc,maincategory mc where sc.subcatdel=1 and sc.maincatid=mc.maincatid and sc.subcatname like '$_REQUEST[search]%' order by sc.subcatname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[0];?></td>
           <td><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Subcategory?')){restore('rsubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Subcategory Permenant?')){delrecycle('rsubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(subcatid) from subcategory where subcatdel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(subcatid) from subcategory where subcatdel=1 and subcatname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rsubcategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rsubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rsubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rsubcategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  





<!--Peta Sub Category-->

<?php
if(@$_REQUEST['tab']=="petasubcategory")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update petasubcategory set petasubcatdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update petasubcategory set petasubcatdel=1 where petasubcatid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from petasubcategory where petasubcatname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update petasubcategory set petasubcatname='$_REQUEST[upval]' where petasubcatid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
<form action="" method="post" name="petasubcategory" id="mainpetacategorydata">
     <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Sub Category Name</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete Allpeta Sub Category Temporary?')){del('petasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">petaSub Category Name</th>
            <th>Update</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select subcatname,petasubcatname,petasubcatid from petasubcategory p,subcategory s where p.petasubcatdel=0 and p.subcatid=s.subcatid order by p.petasubcatname limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select subcatname,petasubcatname,petasubcatid from petasubcategory p,subcategory s where p.petasubcatdel=0 and p.subcatid=s.subcatid and p.petasubcatname like '$_REQUEST[search]%' order by p.petasubcatname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr>
                <td><?php echo $sel1[0]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Peta Sub Category Temporary?')){del('petasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><input class="w3-input" type="text" style="text-align: center;" id="upin" name="uppetasubcategory" value="<?php echo $sel1[1]; ?>" /></td>      
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" onclick="update('petasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',document.getElementById('upin').value);"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
            <td><?php echo $sel1[0]; ?></td>
            <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Deletepeta Subcategory Temporary?')){del('petasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('petasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(petasubcatid) from petasubcategory where petasubcatdel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(petasubcatid) from petasubcategory where petasubcatdel=0 and petasubcatname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('petasubcategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('petasubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('petasubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('petasubcategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--Peta Sub Category Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rpetasubcategory")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update petasubcategory set petasubcatdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update petasubcategory set petasubcatdel=0 where petasubcatid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from petasubcategory where petasubcatdel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from petasubcategory where petasubcatid='$_REQUEST[delid]'");
        }
    }

?>
    <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Sub Category Name</th>
            <th>Peta Sub Category Name</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All petaSubcategory?')){restore('rpetasubcategory','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All petaSubcategory Permenant?')){delrecycle('rpetasubcategory','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
         $sel=  mysqli_query($con,"select subcatname,petasubcatname,petasubcatid from petasubcategory p,subcategory s where p.petasubcatdel=1 and p.subcatid=s.subcatid order by p.petasubcatname limit $st,$pp");
        
        }
        else
        {
        $sel=  mysqli_query($con,"select subcatname,petasubcatname,petasubcatid from petasubcategory p,subcategory s where p.petasubcatdel=1 and p.subcatid=s.subcatid and p.petasubcatname like '$_REQUEST[search]%' order by p.petasubcatname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[0];?></td>
           <td><?php echo $sel1[1]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore petasubcategory?')){restore('rpetasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete petasubcategory Permenant?')){delrecycle('rpetasubcategory','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td>
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(petasubcatid) from petasubcategory where petasubcatdel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(petasubcatid) from petasubcategory where petasubcatdel=1 and petasubcatname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rpetasubcategory','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpetasubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rpetasubcategory','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rpetasubcategory','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  




<!--Company-->

<?php
if(@$_REQUEST['tab']=="company")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update company set companydel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update company set companydel=1 where companyid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select *from company where companyname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update company set companyname='$_REQUEST[upval]' where companyid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Company Temporary?')){del('company','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">Company Name</th>
            <th>Sub Category</th>
            <th>Update</th>
        </tr>

        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select subcatname,companyname,companyid from company c,subcategory s where c.companydel=0 and c.subcatid=s.subcatid order by c.companyname limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select subcatname,companyname,companyid from company c,subcategory s where c.companydel=0 and c.subcatid=s.subcatid and c.companyname like '$_REQUEST[search]%' order by c.companyname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Brand Temporary?')){del('company','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><input class="w3-input" type="text" name="upin" onblur="update('company','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[1]; ?>"/></td>
                <td><?php echo $sel1[0]; ?></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
            <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Brand Temporary?')){del('company','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[1]; ?></td>
            <td><?php echo $sel1[0]; ?></td>
            <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('company','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(companyid) from company where companydel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(companyid) from company where companydel=0 and companyname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('company','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('company','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('company','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('company','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>

<?php
}
?>

<!--Company Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rcompany")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update company set companydel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update company set companydel=0 where companyid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from company where companydel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from company where companyid='$_REQUEST[delid]'");
        }
    }

?>  
<table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Company Name</th>
            <th>Sub Category Name</th>         
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Company?')){restore('rcompany','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Company Permenant?')){delrecycle('rcompany','<?php echo $_REQUEST[p]; ?>','<?php echo $_REQUEST[pp]; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select subcatname,companyname,companyid from company c,subcategory s where c.companydel=1 and c.subcatid=s.subcatid order by c.companyname limit $st,$pp");        
        }
        else
        {
            $sel=  mysqli_query($con,"select subcatname,companyname,companyid from company c,subcategory s where c.companydel=1 and c.subcatid=s.subcatid and c.companyname like '$_REQUEST[search]%' order by c.companyname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
            <td><?php echo $sel1[1]; ?></td>
            <td><?php echo $sel1[0];?></td>  
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Brand?')){restore('rcompany','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Brand Permenant?')){delrecycle('rcompany','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(companyid) from company where companydel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(companyid) from company where companydel=1 and companyname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rcompany','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rcompany','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rcompany','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rcompany','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  





<!--Measure-->

<?php
if(@$_REQUEST['tab']=="measure")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update measure set measuredel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update measure set measuredel=1 where measureid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $up=  mysqli_query($con,"update measure set measure='$_REQUEST[upval]' where measureid='$_REQUEST[updateid]'");
    }
?>

<table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Main Category</th>   
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Measure Temporary?')){del('measure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">Measure</th>
            <th>Update</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select maincatname,measure,measureid from measure m,maincategory mc where m.measuredel=0 and m.maincatid=mc.maincatid order by m.measure limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select maincatname,measure,measureid from measure m,maincategory mc where m.measuredel=0 and m.maincatid=mc.maincatid and measure like '$_REQUEST[search]%' order by m.measure limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[2])
            {
            ?> 
            <tr>
                <td><?php echo $sel1[0]; ?></td>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Measure Temporary?')){del('measure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><input class="w3-input" type="text" name="upmeasure" onblur="update('measure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[1]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
            <td><?php echo $sel1[0]; ?></td>
            <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Measure Temporary?')){del('measure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><?php echo $sel1[1]; ?></td>
            <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('measure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(measureid) from measure where measuredel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(measureid) from measure where measuredel=0 and measure like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('measure','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('measure','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('measure','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('measure','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>

<?php
}
?>

<!--Measure Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rmeasure")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update measure set measuredel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update measure set measuredel=0 where measureid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from measure where measuredel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from measure where measureid='$_REQUEST[delid]'");
        }
    }

?>

     <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
             <th>Main Category Name</th>
            <th>Measure Name</th>         
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Measure?')){restore('rmeasure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Measure Permenant?')){delrecycle('rmeasure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        </tr>
        
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select maincatname,measure,measureid from measure m,maincategory mc where m.measuredel=1 and m.maincatid=mc.maincatid order by m.measure limit $st,$pp"); 
        }
        else
        {
            $sel=  mysqli_query($con,"select maincatname,measure,measureid from measure m,maincategory mc where m.measuredel=1 and m.maincatid=mc.maincatid and measure like '$_REQUEST[search]%' order by m.measure limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
            <td><?php echo $sel1[0]; ?></td>
            <td><?php echo $sel1[1];?></td>  
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Measure?')){restore('rmeasure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Measure Permenant?')){delrecycle('rmeasure','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(measureid) from measure where measuredel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(measureid) from measure where measuredel=1 and measure like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rmeasure','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rmeasure','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rmeasure','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rmeasure','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  







<!--Highlight-->

<?php
if(@$_REQUEST['tab']=="highlight")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update highlight set highlightdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update highlight set highlightdel=1 where highlightid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['updateid']!="")
    {
        $upsel=  mysqli_query($con,"select * from highlight where highlightname like '$_REQUEST[upval]'");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update highlight set highlightname='$_REQUEST[upval]' where highlightid='$_REQUEST[updateid]'");
          }
           else
          {
              echo "<font style='color:red;'>Already Exist</font>";
          }

    }
?>

     <table class="table table-responsive comtab city">
        <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Highlight Temporary?')){del('highlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">Highlight Name</th>
        <th>Update</th>
     
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from highlight where highlightdel=0 order by highlightname limit $st,$pp");
        
        }
        else
        {
       $sel=  mysqli_query($con,"select * from highlight where highlightdel=0 and highlightname like '$_REQUEST[search]%' order by highlightname limit $st,$pp");
        
        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
        
            <tr style="font-size: 13px;">
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete Highlight Temporary?')){del('highlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[2]; ?>');}"><input type="text" name="upin" style="width: 80%;text-align: center;" onblur="update('highlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>',this.value);" style="text-align: center;" id="uparea"  value="<?php echo $sel1[1]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o"  ></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
            <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete Highlight Temporary?')){del('highlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
            <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('highlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="4">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(highlightid) from highlight where highlightdel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(highlightid) from highlight where highlightdel=0 and highlightname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('highlight','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('highlight','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('highlight','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('highlight','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>

<?php
}
?>

<!--Highlight Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rhighlight")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update highlight set highlightdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update highlight set highlightdel=0 where highlightid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from highlight where highlightdel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from highlight where highlightid='$_REQUEST[delid]'");
        }
    }

?>
     <table class="table table-responsive comtab cityrecyclebin">
         <th>highlight Name</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All Highlight?')){restore('rhighlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Highlight Permenant?')){delrecycle('rhighlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
         $sel=  mysqli_query($con,"select * from highlight where highlightdel=1 order by highlightname limit $st,$pp");
        
        }
        else
        {
            $sel=  mysqli_query($con,"select * from highlight where highlightdel=1 and highlightname like '$_REQUEST[search]%' order by highlightname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr style="font-size: 13px;border-bottom: 1px dashed #01c38e;">
            <td><?php echo $sel1[1]; ?></td>  
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore Highlight?')){restore('rhighlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete Highlight Permenant?')){delrecycle('rhighlight','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr>
            <td style="background: #01c38e;" colspan="5">
            <ul class="paging1">
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(highlightid) from highlight where highlightdel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(highlightid) from highlight where highlightdel=1 and highlightname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rhighlight','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rhighlight','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rhighlight','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rhighlight','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  





<!--Banner Pack-->

<?php
if(@$_REQUEST['tab']=="bannerpack")
{
    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=mysqli_query($con,"update bannerpack set bannerpackdel=1");
        }
        else
        {
            $upone=  mysqli_query($con,"update bannerpack set bannerpackdel=1 where bannerpackid='$_REQUEST[delid]'");
        }
    }
    if(@$_REQUEST['upmulid']!="")
    {
        $upsel=  mysqli_query($con,"select *from bannerpack where (bannerpackname like '$_REQUEST[upbannerpack]' and bannerpackday like '$_REQUEST[upbannerpackday]') or (bannerpackname like '$_REQUEST[upbannerpack]' and bannerpackday like '$_REQUEST[upbannerpackday]' and bannerpackprice like '$_REQUEST[upbannerpackprice]')");
        $upsel1=  mysqli_fetch_array($upsel);
        if($upsel1[0]=="")
          { 
             $up=  mysqli_query($con,"update bannerpack set bannerpackname='$_REQUEST[upbannerpack]',bannerpackday='$_REQUEST[upbannerpackday]',bannerpackprice='$_REQUEST[upbannerpackprice]' where bannerpackid='$_REQUEST[upmulid]'");
          }
           else
          {
              echo "<font class='w3-text-red w3-small'>Already Exist</font>";
          }

    }
?>
<form action="" method="post" name="bannerpack" id="mydata" class="profileedit form-group" >
      <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All Banner Package Temporary?')){del('bannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','deleteall');}">Package</th>
            <th>Package Duration(Day)</th>
            <th>Package Price</th>
            <th>Edit</th>
        </tr>

        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from bannerpack where bannerpackdel=0 order by bannerpackname limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from bannerpack where bannerpackdel=0 and bannerpackname like '$_REQUEST[search]%' order by bannerpackname limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            if(@$_REQUEST['upid']==$sel1[0])
            {
            ?>
            <tr>
                <td style="cursor: pointer" ondblclick="if(confirm('Are You Sure Want To Delete bannerpack Temporary?')){del('bannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><input class="w3-input" type="text" style="text-align: center;" id="upin" name="upbannerpack" value="<?php echo $sel1[1]; ?>" /></td>
                <td><input class="w3-input" type="text" style="text-align: center;" name="upbannerpackday" value="<?php echo $sel1[2]; ?>"/></td>
                <td><input class="w3-input" type="text" style="text-align: center;" name="upbannerpackprice" value="<?php echo $sel1[3]; ?>"/></td>
                <td><font><i class="fa fa-pencil-square-o" style="cursor: pointer;" onclick="updatemulti('bannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
            </tr>
        <?php
            }
            else
            {
          ?>
        <tr>
           <td style="cursor: pointer"  ondblclick="if(confirm('Are You Sure Want To Delete bannerpack Temporary?')){del('bannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"><?php echo $sel1[1]; ?></td>
           <td><?php echo $sel1[2]; ?></td>
           <td><?php echo $sel1[3]; ?></td>
           <td><font><i class="fa fa-pencil" style="cursor: pointer;" onclick="up('bannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>')"></i></font></td>
        </tr>
        <?php
         }
        }
       ?>
        <tr class="paging1">
            <td colspan="4">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(bannerpackid) from bannerpack where bannerpackdel=0");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(bannerpackid) from bannerpack where bannerpackdel=0 and bannerpackname like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('bannerpack','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('bannerpack','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('bannerpack','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('bannerpack','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
</form>
<?php
}
?>

<!--bannerpack Recyclebin-->

<?php
if(@$_REQUEST['tab']=="rbannerpack")
{
     if(@$_REQUEST['upid']!="")
    {
        if(@$_REQUEST['upid']=="all")
        {
            $upall=mysqli_query($con,"update bannerpack set bannerpackdel=0");
        }
        else
        {
            $upone=  mysqli_query($con,"update bannerpack set bannerpackdel=0 where bannerpackid='$_REQUEST[upid]'");
        }
    }

    if(@$_REQUEST['delid']!="")
    {
        if(@$_REQUEST['delid']=="all")
        {
            $delall=  mysqli_query($con,"delete from bannerpack where bannerpackdel=1");
        }
        else
        {
            $delone=  mysqli_query($con,"delete from bannerpack where bannerpackid='$_REQUEST[delid]'");
        }
    }

?>
<table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
         <th>Package</th>
         <th>Package Duration(Day)</th>
         <th>Package Price</th>
          <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Restore All bannerpack?')){restore('rbannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}">Restore</th>
         <th style="cursor: pointer;" ondblclick="if(confirm('Are You Sure Want To Delete All bannerpack Permenant?')){delrecycle('rbannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','all');}" >Delete</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
            $sel=  mysqli_query($con,"select * from bannerpack where bannerpackdel=1 order by bannerpackname limit $st,$pp");
        }
        else 
        {
            $sel=  mysqli_query($con,"select * from bannerpack where bannerpackdel=1 and bannerpackname like '$_REQUEST[search]%' order by bannerpackname limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
          ?>
        <tr>
           <td><?php echo $sel1[1];?></td>
           <td><?php echo $sel1[2]; ?></td>
           <td><?php echo $sel1[3]; ?></td>
           <td><font><i class="fa fa-refresh" ondblclick="if(confirm('Are You Sure Want To Restore bannerpack?')){restore('rbannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
           <td><font><i class="fa fa-close" ondblclick="if(confirm('Are You Sure Want To Delete bannerpack Permenant?')){delrecycle('rbannerpack','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}"></i></font></td>
        </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="5">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(bannerpackid) from bannerpack where bannerpackdel=1");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(bannerpackid) from bannerpack where bannerpackdel=1 and bannerpackname like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="recyclebin('rbannerpack','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rbannerpack','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="recyclebin('rbannerpack','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="recyclebin('rbannerpack','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>  

<!-- Service Provider Banner-->


<?php
if(@$_REQUEST['tab']=="banner")
{
        if(@$_REQUEST['delid']=="deleteall")
        {
            $upall=  mysqli_query($con,"update banner set activestatus=0");
        }
        if(@$_REQUEST['ek']=="block")
        {
            $selbanner = mysqli_query($con,"select * from banner b, bannerpack bp where b.bannerpackid=bp.bannerpackid and b.bannerid=$_REQUEST[delid]");
            $selbanner1=mysqli_fetch_array($selbanner);
            $day = $selbanner1['bannerpackday'];
            $activedate = date("Y-m-d");
            $ts = strtotime("+ $day days");
            $endingdate = date("Y-m-d", $ts);
            $updatestatus = mysqli_query($con,"update banner set activestatus=1,activedate='$activedate',endingdate='$endingdate' where bannerid=$_REQUEST[delid]");           
        }

?>
    <table class="w3-table w3-card-2" style="font-size: 13px;">
        <tr class="tableRow">
            <th>Store</th>
            <th>Title</th>
            <th>Package</th>
            <th>Banner Image</th>
            <th>Upload Date</th>
            <th>Active Date</th>
            <th>Ending Date</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
        $sel=  mysqli_query($con,"select * from banner limit $st,$pp");
        }
        else
        {
        $sel=  mysqli_query($con,"select * from banner where   bannername like '$_REQUEST[search]%' limit $st,$pp");        
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                
                <?php
                $bn=  mysqli_query($con,"select businessname from servicesassign where assignid=$sel1[2]");
                $bn1=  mysqli_fetch_array($bn);
                $bp=  mysqli_query($con,"select *from bannerpack where bannerpackid=$sel1[1]");
                $bp1=  mysqli_fetch_array($bp);
                ?>
                <td><?php echo $bn1[0]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $bp1[1]; ?></td>
                <td><img src="<?php echo $sel1[4]; ?>" style="width: 80px;height: 60px;"/></td>
                <td><?php echo $sel1[5]; ?></td>
               
                <td>
                 <?php 
                if($sel1[6] == "0000-00-00" || $sel1[6] == "NULL")
                {
                    echo "-";
                }
                else
                {
                    echo $sel1[6];
                }
                ?>
                </td>
                <td>
                    <?php 
                if($sel1[7] == "0000-00-00" || $sel1[7] == "NULL")
                {
                    echo "-";
                }
                else
                {
                    echo $sel1[7];
                }
                ?>
                </td>
                <?php
                if($sel1[8]==1)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i  class="fa fa-circle" title='Active Banner'/></font></td>
                <?php
                }
                if($sel1[8]==0)
                {
                    ?>
                <td><font style="color: #4E75F3;"><i ondblclick="if(confirm('Are You Sure Want To Active Selected Store\'s Banner?')){del('banner','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>','block');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                if($sel1[8]==2)
                {
                 ?>
                <td><font style="color: red;"><i  class="fa fa-circle" title='Deactive Banner'/></font></td>
                 <?php   
                }
                ?>
            </tr>
        <?php
         }
       ?>
        <tr class="paging1">
            <td colspan="8">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(bannerid) from banner");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(bannerid) from banner where bannername like '$_REQUEST[search]%' ");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('banner','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('banner','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('banner','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('banner','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
    </table>
<?php
}
?>








<!-- Area -->

<?php
if(@$_REQUEST['cityid']!="")  
{
?>
    <option value="">--Select Area--</option>
    <?php
       $selarea=  mysqli_query($con,"select * from area where cityid=$_REQUEST[cityid] and areadel=0 order by areaname");
       while($selarea1=  mysqli_fetch_array($selarea))
       {
        ?>
        <option value="<?php echo $selarea1['areaid']; ?>"><?php echo $selarea1['areaname']; ?></option>
        <?php
       }
}
?>

 <!-- Manage Business-->
         
<?php
if(@$_REQUEST['tab']=="serviceprovider")
{
    if(@$_REQUEST['delid']!="")
    {
        $status = mysqli_query($con,"select * from servicesassign sa,package p where sa.assignid = $_REQUEST[delid] and p.packageid=sa.packageid");
        $status1 = mysqli_fetch_array($status);

        if($status1['status'] == 0)
        {
            $duration = $status1['packageduration'];
            $activedate = date("Y-m-d");
            $ts = strtotime("+ $duration month");
            $endingdate = date("Y-m-d",$ts);
            $updatestatus = mysqli_query($con,"update servicesassign set status=1,activedate='$activedate',endingdate='$endingdate' where assignid=$_REQUEST[delid]");
        }
    }
?>

    <table style="font-size: 13px;" class="w3-table w3-card-2">
        <tr class="tableRow">
            <th>Service Name</th>
            <th>User id</th>
            <th>Store</th>
            <th>Area</th>
            <th>City</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Visiting Card</th>
            <th>Status</th>
        </tr>
        <?php
        $p=$_REQUEST['p'];
        $pp=$_REQUEST['pp'];
        $st=($p*$pp)-$pp;
        if(@$_REQUEST['search']=="")
        {
             $sel=  mysqli_query($con,"select assignid,servicename,userid,businessname,address,areaname,cityname,landmark,contactno,email,map,registrationdate,since,registrationno,url,coverpick,profilepick,visitingcard,packagename,activedate,endingdate,status,packageduration,packageprice from services s,area a,city c,package p,servicesassign sa where s.serviceid=sa.serviceid and a.areaid=sa.areaid and c.cityid=sa.cityid and p.packageid=sa.packageid  order by s.servicename limit $st,$pp");
        }
        else
        {
            $sel=  mysqli_query($con,"select assignid,servicename,userid,businessname,address,areaname,cityname,landmark,contactno,email,map,registrationdate,since,registrationno,url,coverpick,profilepick,visitingcard,packagename,activedate,endingdate,status,packageduration,packageprice from services s,area a,city c,package p,servicesassign sa where s.serviceid=sa.serviceid and a.areaid=sa.areaid and c.cityid=sa.cityid and p.packageid=sa.packageid and sa.userid like '$_REQUEST[search]%' order by s.servicename limit $st,$pp");
        }
        while($sel1=  mysqli_fetch_array($sel))
        {
            ?>
            <tr>
                <td><?php echo $sel1[1]; ?></td>
                <td><?php echo $sel1[2]; ?></td>
                <td><?php echo $sel1[3]; ?></td>
                <td><?php echo $sel1[5]; ?></td>
                <td><?php echo $sel1[7]; ?></td>
                <td><?php echo $sel1[8]; ?></td>
                <td><?php echo $sel1[9]; ?></td>
                <td><?php echo $sel1[11]; ?></td>
                <td><img src="<?php echo $sel1[17]; ?>" style="width: 100px;height: 60px;"/></td>
                    <?php
                if($sel1['status']==1)
                {
                 ?>
                <td><font style="color: #4E75F3;"><i class="fa fa-circle"></i></font></td>
                <?php
                }
                if($sel1['status']==0)
                {
                    ?>
                <td><font><i ondblclick="if(confirm('Are You Sure Want To Active Selected Store?')){del('serviceprovider','<?php echo $_REQUEST['p']; ?>','<?php echo $_REQUEST['pp']; ?>','<?php echo $sel1[0]; ?>');}" class="fa fa-circle-o"/></font></td>
                <?php
                }
                ?>
            </tr>
            <tr style="border-bottom:1px solid #eee;">
                <td colspan="2"><b>Package : </b><?php echo $sel1['packagename']; ?></td>
                <td><b>Duration: </b><?php echo $sel1['packageduration']; ?> Month</td>
                <td colspan="2"><b>Price: </b>Rs. <?php echo $sel1['packageprice']; ?></td>
                <td colspan="2">
                    <b>Active Date : </b>
                    <?php
                    if($sel1['activedate']=="" || $sel1['activedate']=="0000-00-00")
                    {
                        echo "-";
                    }
                    else
                    {
                        echo $sel1['activedate']."<br/><br/>";
                    }
                    ?>
                </td>
                <td colspan="2">
                    <b>Ending Date : </b>
                    <?php
                    if($sel1['endingdate']=="" || $sel1['endingdate']=="0000-00-00")
                    {
                        echo "-";
                    }
                    else
                    {
                        echo $sel1['endingdate']."<br/><br/>";
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
         <tr class="paging1">
            <td colspan="21">
            <ul>
               <?php   
               $p=$_REQUEST['p'];
               $pp=$_REQUEST['pp'];
               $st=($p*$pp)-$pp;
                if(@$_REQUEST['search']=="")
                {
                    $t=  mysqli_query($con,"select count(assignid) from servicesassign");
                }
                else
                {
                    $t=  mysqli_query($con,"select count(assignid) from servicesassign where userid like '$_REQUEST[search]%'");
                }
                $tt=  mysqli_fetch_array($t);

                $page=ceil($tt[0]/$_REQUEST['pp']);
                if($page>=5)
                {
                    $start=$p-2;
                    $end=$p+2;

                        if($start<1)
                        {
                            $start=1;
                            $end=5;
                        }
                        if($end>$page)
                        {
                            $end=$page;
                            $start=$end-3;
                        }
                }
                else 
                {
                        $start=1;
                        $end=$page;
                }

                if($start!=1)
                {
                ?>
                <li class="arrowc" onclick="display('serviceprovider','<?php echo $p-1; ?>','<?php echo $pp; ?>');"><<</li>  
                <?php
                }
                for($i=$start;$i<=$end;$i++)
                {
                  if(@$_REQUEST['p']==$i)
                   {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('serviceprovider','<?php echo $i; ?>','<?php echo $pp; ?>');" class="effpage"><?php echo $i; ?></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li value="<?php echo $i; ?>" onclick="display('serviceprovider','<?php echo $i; ?>','<?php echo $pp; ?>');" class="norpage"><?php echo $i; ?></li>
                   <?php
                    }
               }

                if($page!=$end)
                {
                    ?>
                     <li class="arrowc" onclick="display('serviceprovider','<?php echo $p+1; ?>','<?php echo $pp; ?>');">>></li>  
                     <?php
                }
                ?>              
            </ul>
            </td>
        </tr>
        </table>
<?php
}
?>
       
     
     
     
     
 <!--Admin Side Package Bill -->    
     
     
  <?php
  if(@$_REQUEST['kona']=='missbill')
  {
      if(@$_REQUEST['stid']!=0)
      {
          $d=date("Y-m-d");
          $pack=  mysqli_query($con,"select packageid from servicesassign where assignid like $_REQUEST[stid]");
          $fpack=  mysqli_fetch_array($pack);
          $pn=  mysqli_query($con,"select months from package where packageid=$fpack[0]");
          $pnn=  mysqli_fetch_array($pn);
          $dd=date('Y-m-d', strtotime('+'.$pnn[0]. 'month'));
          $in=  mysqli_query($con,"insert into bill values(0,$_REQUEST[stid],$fpack[0],'$d')");
          $up=  mysqli_query($con,"update servicesassign set status=1,activedate='$d',endingdate='$dd' where assignid=$_REQUEST[stid]");
          
      }
      
      
      
                $d=date("Y-m-d");
                if(@$_REQUEST['konu']=="today")
                {
                    $sel=  mysqli_query($con,"select *from servicesassign where registrationdate like '$d'");
                    
                    $sel2=  mysqli_query($con,"select count(assignid),assignid from servicesassign where registrationdate like '$d'");
                    $ff1=  mysqli_fetch_array($sel2);
                    
                }
                else
                {
                    $sel=  mysqli_query($con,"select *from servicesassign where assignid='$_REQUEST[konu]'");
                    $sel2=  mysqli_query($con,"select count(assignid) from servicesassign where assignid='$_REQUEST[konu]'");
                    $ff1=  mysqli_fetch_array($sel2);
                }
                if($ff1[0]==0)
                {
                  ?>
 <center style="padding-top: 4%;"><font style="color:red;font-size: 24px;"><i class="fa fa-warning">&nbsp;No Bill Found</i></font></center>
                    <?php
                }
             
                while($sel1=  mysqli_fetch_array($sel))
                {
                    $bill=  mysqli_query($con,"select *from bill where assignid= $sel1[0]");
                    $bill1=  mysqli_fetch_array($bill);
                    ?>
        
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 package" style="border: 1px solid #01c38e;box-shadow: 3px 3px 3px #01c38e;">
                        <?php
                        
                        $pack=  mysqli_query($con,"select *from package where packageid=$sel1[17]");
                        $pack1=  mysqli_fetch_array($pack);
                        $ser=  mysqli_query($con,"select *from services where serviceid=$sel1[1]");
                        $ser1=  mysqli_fetch_array($ser);
                        $reg=  mysqli_query($con,"select *from registration where userid like '$sel1[2]'");
                        $reg1=  mysqli_fetch_array($reg);
                        
                        
                        if($sel1[20]==0)
                        {
                            ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                PACKAGE INVOICE<br/>&nbsp;&nbsp;<?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:red;">
                               Pending
                            </div>
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                &nbsp;&nbsp;PACKAGE INVOICE<br/><?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:#01c38e;">
                               Active
                            </div>
                        </div>
                        
                        <?php
                        }
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6  col-sm-12 col-xs-12 packtitle">
                                HAPPY HOME SERVICE<br/><font style="font-size: 14px;">QUALITY SERVICE FOR QUALITY CUSTOMER</font>

                            </div>
                            <div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
                                <img src="images/HOME 01.png" class="img img-responsive" style="width: 30%;"/>
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <font style="font-size: 15px;">Package Detail<br/>
                                <?php echo $reg1[0]; ?>
                                </font>
                            </div>
                            <div class="col-md-3 col-md-offset-3 col-sm-12 col-xs-12">
                                Bill No : <?php echo $bill1[0]; ?><br/>
                                Active Date&nbsp;&nbsp;&nbsp;:&nbsp;<?php 
                                $d=substr($sel1[18],8,2);
                                $m=substr($sel1[18],5,2);
                                $y=substr($sel1[18],0,4);
                                
                                echo $d."-".$m."-".$y;
                                ?>
                                <br/>
                                Ending Date&nbsp;:&nbsp;<?php 
                                $ed=substr($sel1[19],8,2);
                                $em=substr($sel1[19],5,2);
                                $ey=substr($sel1[19  ],0,4);
                                
                                echo $ed."-".$em."-".$ey;
                                ?>
                                
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 " >
                            <table class="table table-responsive packtab" >
                                <tr style="background: #01c38e;color:#fff;">
                                    <th>Business</th>
                                    <th>Package</th>
                                    <th>Package Duration(Month)</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                <tr style="text-transform: capitalize;" >
                                    <td><?php echo $ser1[1]; ?></td>
                                    <td><?php echo $pack1[1]; ?></td>
                                    <td><?php echo $pack1[2]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Tax</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]*2/100; ?></td>
                                    <?php
                                    $st=$pack1[3];
                                    $tax=$pack1[3]*2/100;
                                    
                                    ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Total Due</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $st+$tax; ?></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                         <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 packbottom">
                                <table class="table table-responsive">
                                    <div class="row" style="margin: 0;">
                                        
                                        <div class="col-md-10">
                                             Make all checks payable to Happy Home Service.<br/>
                                        Payment is due within 30 days.<br/>
                                        If you have any questions concerning this invoice, contact: 1800-462-8694, homeservice.krn123@gmail.com<br/>
                                        Thank you for your business!
                                        </div>
                                        <div class="col-md-2" style="padding-top: 2.5%;">
                                            <img src="images/naresh.jpg" class="img img-responsive"/>
                                        </div>
                                     
                                    </div>
                                        
                                </table>
                            </div>
                             
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-offset-10 col-md-2 col-sm-12 col-xs-12">
                                <?php
                                if($sel1[20]==0)
                                {
                                 ?>
                                <font onclick="missbill('missbill','<?php echo $_REQUEST["konu"]; ?>','<?php echo $sel1[0]; ?>')" style="cursor: pointer;">Pay</font>
                                 <?php
                                }
                                else
                                {
                                  ?>
                                <font onclick="adminbillpay();" style="cursor: pointer;">Print Invoice</font>
                                 <?php  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                }
  }
  ?>

 
 <!-- Service Provider Side Package Bill -->    
     
     
  <?php
  if(@$_REQUEST['kona']=='missuserbill')
  {
   
                $d=date("Y-m-d");
                if(@$_REQUEST['konu']=="badha")
                {
                    $sel=  mysqli_query($con,"select *from servicesassign where userid like '$_SESSION[user]'");
                   
                }
                 else
                {
                    $sel=  mysqli_query($con,"select *from servicesassign where assignid='$_REQUEST[konu]'");
                }
      
                while($sel1=  mysqli_fetch_array($sel))
                {
                     $bill=  mysqli_query($con,"select *from bill where assignid=$sel1[0]");
                     $bill1=  mysqli_fetch_array($bill);
                    ?>
        
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 package" style="border: 1px solid #01c38e;box-shadow: 3px 3px 3px #01c38e;">
                        <?php
                        
                        $pack=  mysqli_query($con,"select *from package where packageid=$sel1[17]");
                        $pack1=  mysqli_fetch_array($pack);
                        $ser=  mysqli_query($con,"select *from services where serviceid=$sel1[1]");
                        $ser1=  mysqli_fetch_array($ser);
                        $reg=  mysqli_query($con,"select *from registration where userid like '$sel1[2]'");
                        $reg1=  mysqli_fetch_array($reg);
                        
                        if($sel1[20]==0)
                        {
                            ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                PACKAGE INVOICE<br/>&nbsp;&nbsp;<?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:red;">
                               Pending
                            </div>
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                &nbsp;&nbsp;PACKAGE INVOICE<br/><?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:#01c38e;">
                               Active
                            </div>
                        </div>
                        
                        <?php
                        }
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6  col-sm-12 col-xs-12 packtitle">
                                HAPPY HOME SERVICE<br/><font style="font-size: 14px;">QUALITY SERVICE FOR QUALITY CUSTOMER</font>

                            </div>
                            <div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
                                <img src="images/HOME 01.png" class="img img-responsive" style="width: 30%;"/>
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <font style="font-size: 15px;">Package Detail<br/>
                                <?php echo $reg1[0]; ?>
                                </font>
                            </div>
                            <div class="col-md-3 col-md-offset-3 col-sm-12 col-xs-12">
                                Bill No : <?php echo $bill1[0]; ?><br/>
                                Active Date&nbsp;&nbsp;&nbsp;:&nbsp;<?php 
                                $d=substr($sel1[18],8,2);
                                $m=substr($sel1[18],5,2);
                                $y=substr($sel1[18],0,4);
                                
                                echo $d."-".$m."-".$y;
                                ?>
                                <br/>
                                Ending Date&nbsp;:&nbsp;<?php 
                                $ed=substr($sel1[19],8,2);
                                $em=substr($sel1[19],5,2);
                                $ey=substr($sel1[19],0,4);
                                
                                echo $ed."-".$em."-".$ey;
                                ?>
                                
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 " >
                            <table class="table table-responsive packtab" >
                                <tr style="background: #01c38e;color:#fff;">
                                    <th>Business</th>
                                    <th>Package</th>
                                    <th>Package Duration(Month)</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                <tr style="text-transform: capitalize;" >
                                    <td><?php echo $ser1[1]; ?></td>
                                    <td><?php echo $pack1[1]; ?></td>
                                    <td><?php echo $pack1[2]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]; ?></td>
                                    <td  style="border-bottom: 1px solid #01c38e; " ><?php echo $pack1[3]; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Tax</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]*2/100; ?></td>
                                    <?php
                                    $st=$pack1[3];
                                    $tax=$pack1[3]*2/100;
                                    
                                    ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Total Due</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $st+$tax; ?></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                         <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 packbottom">
                                <table class="table table-responsive">
                                    <div class="row" style="margin: 0;">
                                        
                                        <div class="col-md-10">
                                             Make all checks payable to Happy Home Service.<br/>
                                        Payment is due within 30 days.<br/>
                                        If you have any questions concerning this invoice, contact: 1800-462-8694, homeservice.krn123@gmail.com<br/>
                                        Thank you for your business!
                                        </div>
                                        <div class="col-md-2" style="padding-top: 2.5%;">
                                            <img src="images/naresh.jpg" class="img img-responsive"/>
                                        </div>
                                     
                                    </div>
                                </table>
                            </div>
                             
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-offset-10 col-md-2 col-sm-12 col-xs-12">
                                <font style="cursor: pointer;" onclick="spackagebill();">Print Package Invoice</font>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                }
  }
  ?>
 
 
 
 <!-- Admin Side Banner Bill -->
   
     
     
  <?php
  if(@$_REQUEST['kona']=='missbannerbill')
  {
     if(@$_REQUEST['stid']!=0)
      {
          $d=date("Y-m-d");
          $pack=  mysqli_query($con,"select * from banner where bannerid like $_REQUEST[stid]");
          $fpack=  mysqli_fetch_array($pack);
          $pn=  mysqli_query($con,"select bannerpackday from bannerpack where bannerpackid=$fpack[1]");
          $pnn=  mysqli_fetch_array($pn);
          $dd=date('Y-m-d', strtotime('+'.$pnn[0]. 'days'));
          $in=  mysqli_query($con,"insert into bannerbill values(0,$fpack[2],$fpack[0],$fpack[1],'$d')");
          $up=  mysqli_query($con,"update banner set activestatus=1,activedate='$d',endingdate='$dd' where bannerid=$_REQUEST[stid]");
      }
                $d=date("Y-m-d");
                if(@$_REQUEST['konu']=="today")
                {
                    $sel=  mysqli_query($con,"select *from banner where uploaddate like '$d'");
                    
                    $sel2=  mysqli_query($con,"select count(bannerid),bannerid from banner where uploaddate like '$d'");
                    $ff1=  mysqli_fetch_array($sel2);
                }
                else
                {
                    $sel=  mysqli_query($con,"select *from banner where bannerid='$_REQUEST[konu]'");
                    $sel2=  mysqli_query($con,"select count(bannerid) from banner where bannerid='$_REQUEST[konu]'");
                    $ff1=  mysqli_fetch_array($sel2);
                   
                }
                if($ff1[0]==0)
                {
                  ?>
                         <center style="padding-top: 4%;"><font style="color:red;font-size: 24px;"><i class="fa fa-warning">&nbsp;No Bill Found</i></font></center>
                    <?php
                }
             
                while($sel1=  mysqli_fetch_array($sel))
                {
                    $bill=  mysqli_query($con,"select *from bannerbill where bannerid= $sel1[0]");
                    $bill1=  mysqli_fetch_array($bill);
                    ?>
        
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 package" style="border: 1px solid #01c38e;box-shadow: 3px 3px 3px #01c38e;">
                        <?php
                        
                        $pack=  mysqli_query($con,"select *from bannerpack where bannerpackid=$sel1[1]");
                        $pack1=  mysqli_fetch_array($pack);
                        $ser=  mysqli_query($con,"select *from servicesassign where assignid=$sel1[2]");
                        $ser1=  mysqli_fetch_array($ser);
                        $reg=  mysqli_query($con,"select *from services where serviceid like $ser1[1]");
                        $reg1=  mysqli_fetch_array($reg);
                        $usernm=  mysqli_query($con,"select username from registration where userid like '$ser1[2]'");
                        $usernm1=  mysqli_fetch_array($usernm);
                        
                        if($sel1[8]==0)
                        {
                            ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                BANNER PACKAGE INVOICE<br/>&nbsp;&nbsp;<?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:red;">
                               Pending
                            </div>
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                &nbsp;&nbsp;BANNER PACKAGE INVOICE<br/><?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:#01c38e;">
                               Active
                            </div>
                        </div>
                        
                        <?php
                        }
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6  col-sm-12 col-xs-12 packtitle">
                                HAPPY HOME SERVICE<br/><font style="font-size: 14px;">QUALITY SERVICE FOR QUALITY CUSTOMER</font>

                            </div>
                            <div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
                                <img src="images/HOME 01.png" class="img img-responsive" style="width: 30%;"/>
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <font style="font-size: 15px;">Package Detail<br/>
                                <?php echo $usernm1[0]; ?>
                                </font>
                            </div>
                            <div class="col-md-3 col-md-offset-3 col-sm-12 col-xs-12">
                                Bill No : <?php echo $bill1[0]; ?><br/>
                                Active Date&nbsp;&nbsp;&nbsp;:&nbsp;<?php 
                                $d=substr($sel1[6],8,2);
                                $m=substr($sel1[6],5,2);
                                $y=substr($sel1[6],0,4);
                                
                                echo $d."-".$m."-".$y;
                                ?>
                                <br/>
                                Ending Date&nbsp;:&nbsp;<?php 
                                $ed=substr($sel1[7],8,2);
                                $em=substr($sel1[7],5,2);
                                $ey=substr($sel1[7],0,4);
                                
                                echo $ed."-".$em."-".$ey;
                                ?>
                                
                            </div>
                           
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 " >
                            <table class="table table-responsive packtab" >
                                <tr style="background: #01c38e;color:#fff;">
                                    <th>Business</th>
                                    <th>Service</th>
                                    <th>Banner Package</th>
                                    <th>Package Duration(Day)</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                <tr style="text-transform: capitalize;" >
                                    <td><?php echo $ser1[3]; ?></td>
                                    <td><?php echo $reg1[1]; ?></td>
                                    <td><?php echo $pack1[1]; ?></td>
                                    <td><?php echo $pack1[2]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Tax</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]*2/100; ?></td>
                                    <?php
                                    $st=$pack1[3];
                                    $tax=$pack1[3]*2/100;
                                    
                                    ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Total Due</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $st+$tax; ?></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                         <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 packbottom">
                                <table class="table table-responsive">
                                    <div class="row" style="margin: 0;">
                                        
                                        <div class="col-md-10">
                                             Make all checks payable to Happy Home Service.<br/>
                                        Payment is due within 30 days.<br/>
                                        If you have any questions concerning this invoice, contact: 1800-462-8694, homeservice.krn123@gmail.com<br/>
                                        Thank you for your business!
                                        </div>
                                        <div class="col-md-2" style="padding-top: 2.5%;">
                                            <img src="images/naresh.jpg" class="img img-responsive"/>
                                        </div>
                                     
                                    </div>
                                        
                                </table>
                            </div>
                             
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-offset-10 col-md-2 col-sm-12 col-xs-12">
                                <?php
                                if($sel1[8]==0)
                                {
                                 ?>
                                <font onclick="missbill('missbannerbill',<?php echo $_REQUEST['konu']; ?>,<?php echo $sel1[0]; ?>);" style="cursor: pointer;">Pay</font>
                                 <?php
                                }
                                else
                                {
                                  ?>
                                <font onclick="adbpackbill();" style="cursor: pointer;">Print Invoice</font>
                                 <?php  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                }
  }
  ?>
 
 
 <!-- Service Provider Side Banner Bill -->
   
     
     
  <?php
  if(@$_REQUEST['kona']=='missuserbannerbill')
  {
                $d=date("Y-m-d");
                if(@$_REQUEST['konu']=="badha")
                {
                    $sel=  mysqli_query($con,"select b.*,sa.* from banner b,servicesassign sa where b.assignid=sa.assignid and sa.userid like '$_SESSION[user]' ");
                    
                }
                else
                {
                   $sel=  mysqli_query($con,"select *from banner where bannerid='$_REQUEST[konu]'");
                   
                }

                while($sel1=  mysqli_fetch_array($sel))
                {
                    $bill=  mysqli_query($con,"select *from bannerbill where bannerid=$sel1[0]");
                    $bill1=  mysqli_fetch_array($bill);
                    ?>
        
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 package" style="border: 1px solid #01c38e;box-shadow: 3px 3px 3px #01c38e;">
                        <?php
                        
                        $pack=  mysqli_query($con,"select *from bannerpack where bannerpackid=$sel1[1]");
                        $pack1=  mysqli_fetch_array($pack);
                        $ser=  mysqli_query($con,"select *from servicesassign where assignid=$sel1[2]");
                        $ser1=  mysqli_fetch_array($ser);
                        $reg=  mysqli_query($con,"select *from services where serviceid like $ser1[1]");
                        $reg1=  mysqli_fetch_array($reg);
                        $usernm=  mysqli_query($con,"select username from registration where userid like '$ser1[2]'");
                        $usernm1=  mysqli_fetch_array($usernm);
                        
                        if($sel1[8]==0)
                        {
                            ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                BANNER PACKAGE INVOICE<br/>&nbsp;&nbsp;<?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:red;">
                               Pending
                            </div>
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-4 col-md-offset-4 packhead">
                                &nbsp;&nbsp;BANNER PACKAGE INVOICE<br/><?php echo $sel1[3]; ?>
                            </div>
                            <div class="col-md-1 col-md-offset-3" style="color:#01c38e;">
                               Active
                            </div>
                        </div>
                        
                        <?php
                        }
                        ?>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6  col-sm-12 col-xs-12 packtitle">
                                HAPPY HOME SERVICE<br/><font style="font-size: 14px;">QUALITY SERVICE FOR QUALITY CUSTOMER</font>

                            </div>
                            <div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
                                <img src="images/HOME 01.png" class="img img-responsive" style="width: 30%;"/>
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <font style="font-size: 15px;">Package Detail<br/>
                                <?php echo $usernm1[0]; ?>
                                </font>
                            </div>
                            <div class="col-md-3 col-md-offset-3 col-sm-12 col-xs-12">
                                Bill No : <?php echo $bill1[0]; ?><br/>
                                Active Date&nbsp;&nbsp;&nbsp;:&nbsp;<?php 
                                $d=substr($sel1[6],8,2);
                                $m=substr($sel1[6],5,2);
                                $y=substr($sel1[6],0,4);
                                
                                echo $d."-".$m."-".$y;
                                ?>
                                <br/>
                                Ending Date&nbsp;:&nbsp;<?php 
                                $ed=substr($sel1[7],8,2);
                                $em=substr($sel1[7],5,2);
                                $ey=substr($sel1[7],0,4);
                                
                                echo $ed."-".$em."-".$ey;
                                ?>
                                
                            </div>
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 " >
                            <table class="table table-responsive packtab" >
                                <tr style="background: #01c38e;color:#fff;">
                                    <th>Business</th>
                                    <th>Service</th>
                                    <th>Banner Package</th>
                                    <th>Package Duration(Day)</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                                <tr style="text-transform: capitalize;" >
                                    <td><?php echo $ser1[3]; ?></td>
                                    <td><?php echo $reg1[1]; ?></td>
                                    <td><?php echo $pack1[1]; ?></td>
                                    <td><?php echo $pack1[2]; ?></td>
                                    <td style="border-bottom: 1px solid #01c38e; " ><?php echo $pack1[3]; ?></td>
                                    <td  style="border-bottom: 1px solid #01c38e; " ><?php echo $pack1[3]; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Tax</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $pack1[3]*2/100; ?></td>
                                    <?php
                                    $st=$pack1[3];
                                    $tax=$pack1[3]*2/100;
                                    
                                    ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td  style="border-bottom: 1px solid #01c38e; ">Total Due</td>
                                    <td  style="border-bottom: 1px solid #01c38e; "><?php echo $st+$tax; ?></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                         <div class="row" style="margin: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12 packbottom">
                                <table class="table table-responsive">
                                    <div class="row" style="margin: 0;">
                                        
                                        <div class="col-md-10">
                                             Make all checks payable to Happy Home Service.<br/>
                                        Payment is due within 30 days.<br/>
                                        If you have any questions concerning this invoice, contact: 1800-462-8694, homeservice.krn123@gmail.com<br/>
                                        Thank you for your business!
                                        </div>
                                        <div class="col-md-2" style="padding-top: 2.5%;">
                                            <img src="images/naresh.jpg" class="img img-responsive"/>
                                        </div>
                                     
                                    </div>
                                        
                                </table>
                            </div>
                             
                        </div>
                        <div class="row" style="margin: 2%;">
                            <div class="col-md-offset-9 col-md-3 col-sm-12 col-xs-12">
                               <font style="cursor: pointer;" onclick="sbannerpackagebill();">Print Banner Package Invoice</font>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                }
  }
  ?>
 
 
 <!-- Package Information Display Table-->
 
 <?php
 if(@$_REQUEST['kona']=="packageinfo")
 {
 ?>
 <div class="col-md-10 col-md-offset-1" style="margin-top: 5%;">
                                <table class="table table-responsive table-bordered mis" style="text-transform: capitalize;">
                                    <tr>
                                        <th>No.</th>
                                        <th>PACKAGE</th>
                                        <th>DURATION</th>
                                        <th>PRICE</th>
                                        <th>ONECARD</th>
                                    </tr>
                                    <?php
                                    $c=0;
                                    $sel=  mysqli_query($con,"select *from package where packagedel=0 order by packageprice");
                                    while($sel1=  mysqli_fetch_array($sel))
                                    {
                                        $c++;
                                        if($sel1[0]==$_REQUEST['konu'])
                                        {
                                            ?>
                                        
                                        <tr style="border-bottom: 3px solid #01c38e;" class="animated hale" >
                                            <td class="f"><?php echo $c; ?></td>
                                            <td><?php echo $sel1[1]; ?></td>
                                            <td><?php echo $sel1[2]; ?></td>
                                            <td><?php echo $sel1[3]; ?></td>
                                            <td><i class="fa fa-check"></i></td>
                                        </tr>
                                    <?php
                                        }
                                        else
                                        {
                                        ?>
                                         <tr>
                                            <td class="f"><?php echo $c; ?></td>
                                            <td><?php echo $sel1[1]; ?></td>
                                            <td><?php echo $sel1[2]; ?></td>
                                            <td><?php echo $sel1[3]; ?></td>
                                            <td><i style="color:#01c38e;" class="fa fa-check"></i></td>
                                         </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                         <tr>
                                             <td class="f" colspan="5">
                                                 Total Package Are : <?php echo $c; ?>
                                             </td>
                                         </tr>
                                </table>
                            </div>
 <?php
 }
 ?>

 
 
  <!-- Banner Package Information Display Table-->
 
 <?php
 if(@$_REQUEST['kona']=="bannerinfo")
 {
 ?>
 <div class="col-md-10 col-md-offset-1" style="margin-top: 5%;">
                                <table class="table table-responsive table-bordered mis" style="text-transform: capitalize;">
                                    <tr>
                                        <th>No.</th>
                                        <th>PACKAGE</th>
                                        <th>DURATION</th>
                                        <th>PRICE</th>
                                        <th>ONECARD</th>
                                    </tr>
                                    <?php
                                    $c=0;
                                    $sel=  mysqli_query($con,"select *from bannerpack where bannerpackdel=0 order by bannerpackprice");
                                    while($sel1=  mysqli_fetch_array($sel))
                                    {
                                        $c++;
                                        if($sel1[0]==$_REQUEST['konu'])
                                        {
                                            ?>
                                        
                                        <tr style="border-bottom: 3px solid #01c38e;" class="animated hale" >
                                            <td class="f"><?php echo $c; ?></td>
                                            <td><?php echo $sel1[1]; ?></td>
                                            <td><?php echo $sel1[2]; ?></td>
                                            <td><?php echo $sel1[3]; ?></td>
                                            <td><i class="fa fa-check"></i></td>
                                        </tr>
                                    <?php
                                        }
                                        else
                                        {
                                        ?>
                                         <tr>
                                             <td class="f"><?php echo $c; ?></td>
                                            <td><?php echo $sel1[1]; ?></td>
                                            <td><?php echo $sel1[2]; ?></td>
                                            <td><?php echo $sel1[3]; ?></td>
                                            <td><i style="color:#01c38e;" class="fa fa-check"></i></td>
                                         </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                         <tr>
                                             <td class="f" colspan="5">
                                                 Total Banner Package Are : <?php echo $c; ?>
                                             </td>
                                         </tr>
                                </table>
                            </div>
 <?php
 }
 ?>
 
 
 <!-- Service Provider Contact Form -->
 <?php
 if(@$_REQUEST['kona']=="missservicecontact" && @$_REQUEST['konu']!="")
 {
     $sel=  mysqli_query($con,"select servicename,businessname,address,areaname,cityname,contactno,email,map,url,assignid  from services s,area a,city c,servicesassign sa where s.serviceid=sa.serviceid and a.areaid=sa.areaid and c.cityid=sa.cityid and assignid=$_REQUEST[konu]");
     $sel1=  mysqli_fetch_array($sel);
     $_SESSION['ass']=$sel1[9];
 ?>
 <div class="contactform col-md-7 col-sm-12 col-xs-12">
                        <form  action="" method="post" name="contact" class="form-group">

                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="connameicon">
                                    <font><i class="fa fa-user"></i></font>
                                </div>
                                <input type="text" class="form-control textborder reginput"  name="conname"  pattern="^[A-Za-z ]+$" id="conname" required="" placeholder="Enter Your Name..." />
                            </div>                        
                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="conemailicon">
                                    <font><i class="fa fa-envelope"></i></font>
                                </div>
                                <input type="email" style="padding:5% 3.5% 5%" class="form-control textborder reginput"  name="conemail"  id="conemail" required="" placeholder="Enter Your Email..." />
                            </div>
                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="conmessageicon">
                                    <font><i class="fa fa-pencil"></i></font>
                                </div>
                                <input type="text" class="form-control textborder reginput" pattern="^[A-Za-z0-9 ,.?]+$"  name="conmessage" id="conmessage" required="" placeholder="Message..." />
                            </div>
                            <div class="row contactbutton" style="margin:0;">
                                <div class="col-md-5">
<?php
if (@$contact == 1) {
    echo "Thank you for contact";
}
?>
                                </div>
                                <div class="col-md-7">
                                    <button type="submit" style="color:#ffffff;" class="btn btn-danger" name="contact" onclick="missuserbill('missservicecontact',<?php echo $_REQUEST[konu];?>);">Send Message</button>
                                    <button type="reset" style="color:#ffffff;" class="btn btn-danger" name="reset">Clear</button>
                                </div>
                                
                            </div>
                            
                        </form>
                    </div>
                    
                    <div class="contactno col-md-5 col-sm-12 col-xs-12" style="text-transform: capitalize;">
                        <div class="row" style="margin: 0;padding-top: 7%;">
                            <font><i class="fa fa-wrench"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[0]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-building"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[1]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-location-arrow"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[2]; ?>,<?php echo $sel1[3]; ?>,<?php echo $sel1[4]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[5]; ?>
                        </div class="row" style="margin: 0;">
                        <div style="text-transform: none;">
                            <font><i class="fa fa-envelope"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="https://accounts.google.com/ServiceLogin?sacu=1#identifier"> <?php echo $sel1[6]; ?></a>
                        </div>
                        <div>
                            <font><i class="fa fa-whatsapp"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#">+91 <?php echo $sel1[5]; ?></a>
                        </div>
                        <div style="text-transform: none;">
                            <font><i class="fa fa-external-link-square"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $sel1[8]; ?>"><?php echo $sel1[8]; ?></a>
                        </div>
                        
                        <div style="text-transform: none;padding-top: 5%;font-size: 16px;">
                            Follow &nbsp
                            
                            <?php
    
                            if(@$_SESSION['user']!="")
                            {
                                 $ch=  mysqli_query($con,"select *from follow where assignid=$_SESSION[ass] and userid='$_SESSION[user]'");
                                 $chh=  mysqli_fetch_array($ch);
                                 if($chh[0]=="")
                                 {
                            ?>
                            <font><i class="fa fa-thumbs-down" ondblclick="foll('foll');"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                                 }
                                 else
                                 {
                            ?>
                            <font><i class="fa fa-thumbs-up" ondblclick="foll('foll');"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <?php
                                 }
                            }
                            ?>
                            
                        </div>
                    </div>
                    
                    <div class="map col-md-12 col-sm-12 col-xs-12">
                        <iframe src="<?php echo $sel1[7]; ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
 <?php
 }
 ?>

 
 
 
 <!--follow -->
 <?php
  if(@$_REQUEST['kona']=="foll")
 {
    $ch1=  mysqli_query($con,"select * from follow where assignid=$_SESSION[ass] and userid like '$_SESSION[user]'");
    $chh1=  mysqli_fetch_array($ch1); 
    if($chh1[0]!="")
    {
        $del=  mysqli_query($con,"delete from follow where assignid=$_SESSION[ass] and userid='$_SESSION[user]'");
        $ok=1;
    }
    $d=date("Y-m-d");  
    if($ok!=1)
    {
    $in=  mysqli_query($con,"insert into follow values(0,$_SESSION[ass],'$_SESSION[user]','$d')");
   
    }
    $sel=  mysqli_query($con,"select servicename,businessname,address,areaname,cityname,contactno,email,map,url,assignid  from services s,area a,city c,servicesassign sa where s.serviceid=sa.serviceid and a.areaid=sa.areaid and c.cityid=sa.cityid and sa.assignid like $_SESSION[ass]");
    $sel1=  mysqli_fetch_array($sel);
    
      
 ?>
 <div class="contactform col-md-7 col-sm-12 col-xs-12">
                        <form  action="" method="post" name="contact" class="form-group">

                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="connameicon">
                                    <font><i class="fa fa-user"></i></font>
                                </div>
                                <input type="text" class="form-control textborder reginput"  name="conname"  pattern="^[A-Za-z ]+$" id="conname" required="" placeholder="Enter Your Name..." />
                            </div>                        
                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="conemailicon">
                                    <font><i class="fa fa-envelope"></i></font>
                                </div>
                                <input type="email" style="padding:5% 3.5% 5%" class="form-control textborder reginput"  name="conemail"  id="conemail" required="" placeholder="Enter Your Email..." />
                            </div>
                            <div class="input-group con" >
                                <div class="input-group-addon contactjoin" id="conmessageicon">
                                    <font><i class="fa fa-pencil"></i></font>
                                </div>
                                <input type="text" class="form-control textborder reginput" pattern="^[A-Za-z0-9 ,.?]+$"  name="conmessage" id="conmessage" required="" placeholder="Message..." />
                            </div>
                            <div class="row contactbutton" style="margin:0;">
                                <div class="col-md-5">
<?php
if (@$contact == 1) {
    echo "Thank you for contact";
}
?>
                                </div>
                                <div class="col-md-7">
                                    <button type="submit" style="color:#ffffff;" class="btn btn-danger" name="contact" onclick="missuserbill('missservicecontact',<?php echo $_REQUEST[konu];?>);">Send Message</button>
                                    <button type="reset" style="color:#ffffff;" class="btn btn-danger" name="reset">Clear</button>
                                </div>
                                
                            </div>
                            
                        </form>
                    </div>
                    
                    <div class="contactno col-md-5 col-sm-12 col-xs-12" style="text-transform: capitalize;">
                        <div class="row" style="margin: 0;padding-top: 7%;">
                            <font><i class="fa fa-wrench"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[0]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-building"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[1]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-location-arrow"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[2]; ?>,<?php echo $sel1[3]; ?>,<?php echo $sel1[4]; ?>
                        </div>
                        <div class="row" style="margin: 0;">
                            <font><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $sel1[5]; ?>
                        </div class="row" style="margin: 0;">
                        <div style="text-transform: none;">
                            <font><i class="fa fa-envelope"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="https://accounts.google.com/ServiceLogin?sacu=1#identifier"> <?php echo $sel1[6]; ?></a>
                        </div>
                        <div>
                            <font><i class="fa fa-whatsapp"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#">+91 <?php echo $sel1[5]; ?></a>
                        </div>
                        <div style="text-transform: none;">
                            <font><i class="fa fa-external-link-square"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $sel1[8]; ?>"><?php echo $sel1[8]; ?></a>
                        </div>
                        
                        <div style="text-transform: none;padding-top: 5%;font-size: 16px;">
                            Follow &nbsp
                            <?php
    
                            if(@$_SESSION['user']!="")
                            {
                                 $ch=  mysqli_query($con,"select *from follow where assignid=$_SESSION[ass] and userid='$_SESSION[user]'");
                                 $chh=  mysqli_fetch_array($ch);
                                 if($chh[0]=="")
                                 {
                            ?>
                            <font><i class="fa fa-thumbs-down" ondblclick="foll('foll');"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                                 }
                                 else
                                 {
                            ?>
                            <font><i class="fa fa-thumbs-up" ondblclick="foll('foll');"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <?php
                                 }
                            }
                            ?>
                            
                            
                        </div>
                    </div>
                    
                    <div class="map col-md-12 col-sm-12 col-xs-12">
                        <iframe src="<?php echo $sel1[7]; ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
 <?php
 }
 ?>
 
 
 
 <?php
 if(@$_REQUEST['kayutable']=='subcat')
 {
 ?>    
   <option value="" disabled="" selected="">--Select Sub Category--</option>
    <?php
    $mc=  mysqli_query($con,"select *from subcategory where maincatid=$_REQUEST[val] and subcatdel=0");
    while($mc1=  mysqli_fetch_array($mc))
    {
        ?>
    <option value="<?php echo $mc1[0]; ?>"><?php echo $mc1[2]; ?></option>

    <?php    
    }
    ?>
 <?php
 }
 ?>

 <?php
 if(@$_REQUEST['kayutable']=='petasubcat')
 {
 ?>    
   <option value="" disabled="" selected="">--Select Peta Sub Category--</option>
    <?php
    $mc=  mysqli_query($con,"select *from petasubcategory where subcatid=$_REQUEST[val] and petasubcatdel=0");
    while($mc1=  mysqli_fetch_array($mc))
    {
        ?>
    <option value="<?php echo $mc1[0]; ?>"><?php echo $mc1[2]; ?></option>

    <?php    
    }
    ?>
 <?php
 }
 ?>

  <?php
 if(@$_REQUEST['kayutable']=='company')
 {
 ?>    
   <option value="" selected="" disabled="">--Select Brand--</option>
    <?php
    $mc=  mysqli_query($con,"select *from company where subcatid=$_REQUEST[val] and companydel=0");
    while($mc1=  mysqli_fetch_array($mc))
    {
        ?>
    <option value="<?php echo $mc1[0]; ?>"><?php echo $mc1[2]; ?></option>

    <?php    
    }
    ?>
 <?php
 }
 ?>

 <?php
 if(@$_REQUEST['kayutable']=='measure')
 {
 ?>    
   <option value="" disabled="" selected="">--Select Measure--</option>
    <?php
    $mc=  mysqli_query($con,"select *from measure where maincatid=$_REQUEST[val] and measuredel=0");
    while($mc1=  mysqli_fetch_array($mc))
    {
        ?>
    <option value="<?php echo $mc1[0]; ?>"><?php echo $mc1[2]; ?></option>

    <?php    
    }
    ?>
 <?php
 }
 ?>

    
    
    
    
 <!-- Admin Package MIS-->  
    
<?php    
if(@$_REQUEST['kona']=="seapack")
{
?>    
<table class="table table-responsive table-bordered mis">
                            <tr>
                            <th>No.</th>
                            <th>Service Provider Name</th>
                            <th>Package Name</th>
                            <th>Package Duration</th>
                            <th>Amount</th>
                            <th>Date</th>
                            </tr>
                      <?php
                      $c=0;
                      if(@$_REQUEST['koni']=="badhu")
                      {
                        $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid");
                      }
                      if(@$_REQUEST['koni']=="business")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and s.businessname like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="name")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packagename like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="duration")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packageduration like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="amount")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packageprice like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="date")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and b.date like '$_REQUEST[shu]%'");
                      }
                      while($row1=  mysqli_fetch_array($data1))
                      {
                          $c++;
                              ?>
                        
                        
                            <tr>
                                <td class="f" titile="<?php echo $c; ?>"><?php echo $c; ?></td>
                                <td><?php echo $row1[0]; ?></td>
                                <td><?php echo $row1[1]; ?></td>
                                <td><?php echo $row1[2]; ?></td>
                                <td><?php echo $row1[3]; ?></td>
                                <td><?php echo $row1[4]; ?></td>
                            </tr>
                       
                                
                        <?php
                          
                      }
                      ?>
                            <tr>
                                <td colspan="3" class="f">
                                    Total Package MIS Record Are : <?php echo $c; ?>
                                </td>
                                <td colspan="3" class="f">
                                    <font onclick="adpackmis();">Print Here To Print MIS Record..!</font>
                                </td>
                            </tr>
                            
                            
                            
                            
                             </table>
 <?php
 }
 ?>

 
 
 <!-- Service Provider Package MIS-->

<?php    
if(@$_REQUEST['kona']=="serviceproviderseapack")
{
?>    
<table class="table table-responsive table-bordered mis">
                            <tr>
                            <th>No.</th>
                            <th>Service Provider Name</th>
                            <th>Package Name</th>
                            <th>Package Duration</th>
                            <th>Amount</th>
                            <th>Date</th>
                            </tr>
                      <?php
                      $c=0;
                   
                      if(@$_REQUEST['koni']=="badhu")
                      {
                        $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="business")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and s.businessname like '$_REQUEST[shu]%' and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="name")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packagename like '$_REQUEST[shu]%' and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="duration")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packageduration like '$_REQUEST[shu]%' and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="amount")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and p.packageprice like '$_REQUEST[shu]%' and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="date")
                      {
                          $data1=mysqli_query($con,"select s.businessname,p.packagename,p.packageduration,p.packageprice,b.date from servicesassign s,package p,bill b where s.assignid=b.assignid and p.packageid=s.packageid and p.packageid=b.packageid and b.date like '$_REQUEST[shu]%' and s.userid like '$_SESSION[user]'");
                      }
                      while($row1=  mysqli_fetch_array($data1))
                      {
                          $c++;
                              ?>
                        
                        
                            <tr>
                                <td class="f" titile="<?php echo $c; ?>"><?php echo $c; ?></td>
                                <td><?php echo $row1[0]; ?></td>
                                <td><?php echo $row1[1]; ?></td>
                                <td><?php echo $row1[2]; ?></td>
                                <td><?php echo $row1[3]; ?></td>
                                <td><?php echo $row1[4]; ?></td>
                            </tr>
                       
                                
                        <?php
                          
                      }
                      ?>
                            <tr>
                                <td colspan="3" class="f">
                                    Total Package MIS Record Are : <?php echo $c; ?>
                                </td>
                                <td colspan="3" class="f">
                                    <font onclick="serviceprovidermis();">Click Here To Print Your Record..!</font>
                                </td>
                            </tr>
                            
                            
                            
                            
                             </table>
 <?php
 }
 ?>
 
 <!--Provision Service Provider Rate -->
 
 
<?php
if(@$_REQUEST['kona']=="rate")
{
  $k=  mysqli_query($con,"select * from rate where userid like '$_SESSION[user]' and assignid=$_SESSION[id] ");
  $kk=  mysqli_fetch_array($k);  
  if($kk[0]=="")
  {
      if(@$_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"insert into rate values(0,$_SESSION[id],'$_SESSION[user]',$_REQUEST[val])");
      }
  }
  else
  {
      if(@$_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"update rate set rate=$_REQUEST[val] where userid like '$_SESSION[user]' and assignid=$_SESSION[id]");
      } 
  }
   if(@$_SESSION['user']=="")
   {
   for($i=1;$i<=5;$i++)
   {
   ?>

    <i class="fa fa-bookmark-o srate" title="Give Rate After Login"></i>

    <?php
   }
   }
   else
   {

    ?>
    
    <?php
    $ha=  mysqli_query($con,"select rate from rate where userid like '$_SESSION[user]' and assignid=$_SESSION[id]");
    $haa=  mysqli_fetch_array($ha);
   
   for($i=1;$i<=5;$i++)
   {
       if($i<=$haa[0])
       {
   ?>
    <i class="fa fa-bookmark srate" style="cursor: pointer;" onclick="grate('rate',<?php echo $i; ?>)"></i>
    <?php
       }
       else
       {
       ?>
        <i class="fa fa-bookmark-o srate" style="cursor: pointer;" onclick="grate('rate',<?php echo $i; ?>)"></i>
       <?php
       }
   }
   }
}
    ?>
        
        
        
        

        
        
        
        
<!--Product Rate -->
 
 
<?php

if(@$_REQUEST['kona']=="prate")
{
    $userid = @$_SESSION['user'];
  $k=  mysqli_query($con,"select * from rateproduct where userid='$userid' and productid=$_SESSION[proid]");
  $kk=  mysqli_fetch_array($k);  
  if(@$kk[0]=="")
  {
      if(@$_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"insert into rateproduct values(0,$_SESSION[proid],'$userid',$_REQUEST[val])");
      }
  }
  else
  {
      if(@$_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"update rateproduct set rate=$_REQUEST[val] where userid like '$userid' and productid=$_SESSION[proid]");
      } 
  }

   if(@$userid=="")
   {
   for($i=1;$i<=5;$i++)
   {
   ?>
    <i class="fa fa-star-o srate" onclick="if(confirm('Please First Login...')){window.location.href='sign.php'};"></i>
    <?php
   }
   }
   else
   {
    ?>
    <?php
    $ha=  mysqli_query($con,"select rate from rateproduct where userid like '$userid' and productid=$_SESSION[proid]");
    $haa=  mysqli_fetch_array($ha);
   
   for($i=1;$i<=5;$i++)
   {
       if($i<=$haa[0])
       {
   ?>
    <i class="fa fa-star srate" style="cursor: pointer;color:#FCDE05;" onclick="prate('prate',<?php echo $i; ?>)"></i>
    <?php
       }
       else
       {
       ?>
        <i class="fa fa-star-o srate" style="cursor: pointer;" onclick="prate('prate',<?php echo $i; ?>)"></i>
       <?php
       }
   }
   }
}
    ?>     
        
        
<!-- Wish list -->


<?php        
if(@$_REQUEST['tab']=="wishlist")
{
    if(@$_REQUEST['id']!="")
    {
        $delwish=  mysqli_query($con,"delete from wishlist where productid=$_REQUEST[id]");
    }
?>    
<div class="row" style="margin: 0;">
                        <?php
                        
                        $pro=  mysqli_query($con,"select p.*,w.* from productmaster p,wishlist w where p.productid=w.productid and w.userid like '$_SESSION[user]'");
                        while($pro1=  mysqli_fetch_array($pro))
                        {
                            $sel=  mysqli_query($con,"select sa.businessname,m.maincatname,s.subcatname,ps.petasubcatname,c.companyname,me.measure from measure me,company c,petasubcategory ps,subcategory s,maincategory m, productmaster p,servicesassign sa,wishlist w,registration r where p.productid=$pro1[0] and sa.assignid=p.assignid and m.maincatid=p.maincatid and s.subcatid=p.subcatid and ps.petasubcatid=p.petasubcatid and c.companyid=p.companyid and me.measureid=p.measureid and p.productid=w.productid and r.userid like '$_SESSION[user]'");
                            $sel1=  mysqli_fetch_array($sel);
                           ?>

                                <div class="col-md-3 proshow">
                                    <div class="row" style='padding: 5px;'>
                                        
                                        
                                        <div class='col-md-offset-10 col-md-2'>
                                            <i class='fa fa-close' style='cursor: pointer;' onclick="getwish('wishlist',<?php echo $pro1[16]; ?>)" title='Remove Product From Wishlist'></i>
                                        </div>
                                        <div class="col-md-6" style="text-align: center;padding: 5px;background-color: #01c38e;color:#fff;">
                                           <?php
                                                    $selrate=  mysqli_query($con,"select count(*) from rateproduct where productid=$pro1[0]");
                                                    $selrate1=  mysqli_fetch_array($selrate);
                                                    $selr=  mysqli_query($con,"select sum(rate) from rateproduct where productid=$pro1[0]");
                                                    $selr1=  mysqli_fetch_array($selr);
                                                    $cn=floor($selr1[0]/$selrate1[0]);
                                                   
                                                    for($i=1;$i<=5;$i++)
                                                    {
                                                        if($i<=$cn)
                                                        {
                                                    ?>
                                                    <i class='fa fa-star' style='padding: 2px;'></i>
                                                    <?php    
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <i class='fa fa-star-o' style='padding: 2px;'></i>
                                                    
                                                    <?php
                                                    }
                                                    }
                                                    ?>
                                        </div>
                                        
                                        <div class="col-md-6" style="text-align: center;padding: 5px;background-color: #eee;">
                                            <a href="productinfo.php?proid=<?php echo $pro1[0]; ?>#header" style="cursor: pointer;">Add To Cart&nbsp;<i style="font-size: 16px;" class="fa fa-cart-plus"></i></a>
                                        </div>
                                        <div class="col-md-12 productshad" style="padding: 5px;align: center;border-bottom: 2px solid #01c38e;">
                                            <a href="productinfo.php?proid=<?php echo $pro1[0]; ?>#header"><img src="<?php echo $pro1[13]; ?>" class="motophoto" style="width:100%;height:40%;" title="<?php echo $pro1[12]; ?>" class="img img-responsive animated flipInX"/></a>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;text-transform: capitalize;padding: 5px;border-bottom: 1px solid #eee;">
                                          <?php echo $sel1[3]; ?>
                                        </div>
                                        <div class="col-md-6" style="text-align: center;padding: 5px;border-bottom: 1px solid #eee;">
                                            Rs. <del><?php $a=($pro1[7]*110)/100; echo ceil($a); ?></del>&nbsp;<font style="color:#1b1b1b;font-size: 16px;">(<?php echo $pro1[7]; ?>)&nbsp;/-</font>
                                        </div>
                                        
                                        <div class="col-md-6" style="padding: 5px;text-align: center;color:#1b1b1b;">
                                            <?php echo $sel1[4]; ?>
                                        </div>
                                        
                                        
                                        <div class="col-md-12" style="text-align: center;padding: 5px;background-color: #01c38e;">
                                            <a style="color: #fff;letter-spacing: 1px;" href="productinfo.php?proid=<?php echo $pro1[0]; ?>#header"><i class="fa fa-search"></i>&nbsp;More Detail...</a>
                                        </div>
                                    </div>
                                </div>
                             <?php
                            }
                            ?>
                        </div>
<?php
}
?>

        
<!-- My Cart-->        
        
<?php
if(@$_REQUEST['kona']=="misscart")
{
    if(@$_REQUEST['cid']!=0 && @$_REQUEST['q']==0)
    {
        $delcart=  mysqli_query($con,"delete from cart where cartid=$_REQUEST[cid]");
        unset($_SESSION['confirm']);
    }
    if(@$_REQUEST['cid']!=0 && @$_REQUEST['q']!=0)
    {
       $cartprice=  mysqli_query($con,"select price from cart where cartid=$_REQUEST[cid]");
       $cartprice1=  mysqli_fetch_array($cartprice);
       $pricenew=(($cartprice1[0])*($_REQUEST['q']));
       $newgtotal=$pricenew-0;
       $upcart=  mysqli_query($con,"update cart set qty=$_REQUEST[q],totalprice=$pricenew,grandtotal=$newgtotal where cartid=$_REQUEST[cid]");
    }
?>
    
                                
                                <?php
                                
                                $selc=  mysqli_query($con,"select * from cart where userid like '$_SESSION[user]'");
                                $selc1=  mysqli_fetch_array($selc);
                                if($selc1[0]=="")
                                {
                                   
                                ?>
                                
                                    <div class="row" style="margin: 0;">
                                        <div class="col-md-4 col-md-offset-4">
                                            <img src="images/shop.png"  style="width: 80%;height: 40%;opacity: 0.2;" class="img img-responsive"/>
                                        </div> 
                                        <div class="col-md-4 col-md-offset-4">
                                            <font style="font-size: 30px;color:#01c38e;font-weight: bold;">Your Cart Is Now Empty</font>
                                        </div>
                                        <div class="col-md-4 col-md-offset-4" style="margin-top: 1%;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="product.php" ><font  style="font-size: 20px;color:#01c38e;font-weight: bold;">Continue Shopping</font></a>
                                        </div>
                                    </div>
                                
                                <?php
                                }
                                else
                                {
                                    
                                    ?>
                                    <table class="table table-responsive table-bordered mis">
                                    <tr>
                                    <th>No.</th>
                                    <th>Product image</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Discount(%)</th>
                                    <th>Grand Total</th>
                                    <th>Delete</th>
                                </tr>
                                <?php
                                $c=0;
                                $data=  mysqli_query($con,"select * from cart where userid like '$_SESSION[user]'");
                                while($data1=  mysqli_fetch_array($data))
                                {
                                    $c++;
                                    $pro=  mysqli_query($con,"select imagepath,petasubcatid,description,measureid from productmaster where productid=$data1[1]");
                                    $pro1=  mysqli_fetch_array($pro);
                                    $proname=  mysqli_query($con,"select petasubcatname from petasubcategory where petasubcatid=$pro1[1]");
                                    $proname1=  mysqli_fetch_array($proname);
                                    $selm=  mysqli_query($con,"select measure from measure where measureid=$pro1[3]");
                                    $selm1=  mysqli_fetch_array($selm);
                                   
                                ?>
                               
                                    <tr>
                                        <td class="f"><?php echo $c; ?></td>
                                        <td><img src="<?php echo $pro1[0]; ?>" style="width: 100%;height: 30%;" class="img img-responsive"/></td>
                                        <td><?php echo $proname1[0];?></td>
                                        <td>
                                            <?php 
                                            if(@$_SESSION['ch1']==1 && @$_SESSION['proid']==$data1[1])
                                            {
                                                echo "<font class='zabuk'>Already Exist</font>"."<br/><br/>";
                                                unset($_SESSION['ch1']);
                                            }
                                            
                                            echo $pro1[2];
                                            ?>
                                        </td>
                                        <td>&#8377;&nbsp;<?php $a=ceil(($data1[4]*$data1[6])/100);echo $b=$a+$data1[4];?></td>
                                        <td><input onchange="misscart('misscart',<?php echo $data1[0]; ?>,this.value);" type="number" min="1" max="5" value="<?php echo $data1[3];?>"/><br/><font style="text-transform: capitalize;"><?php echo $selm1[0]; ?></font></td>
                                        <td><?php echo $data1[6];?>.00</td>
                                        <td>&#8377;&nbsp;<?php echo $data1[7];?></td>
                                        <td><a><i ondblclick="misscart('misscart',<?php echo $data1[0]; ?>,0);" class="fa fa-close" style="font-size: 16px;" title="Delete Product From The Cart Using Double Click"></i></a><br/><br/><a href="productinfo.php?proid=<?php echo $data1[1]; ?>#header"><i style="font-size: 16px;" title="Click Here To Display Full Detail Of Product" class="fa fa-arrow-right"></i></a></td>
                                       
                                    </tr>
                               
                                <?php
                                }
                                ?>
                                    <tr style="background: #eee;">
                                    <td colspan="9" style="border-right: none;">
                                        <font>Total Added Product In cart Are : <?php echo $c; ?></font>
                                    <br/>
                                        
                                        <a class="motoa" href="product.php" title="Click Here To Go For Continue Shopping"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go To All Product</a>&nbsp;|
                                        <?php
                                        if($selc1[0]!="")
                                        {
                                            $_SESSION['confirm']=1;
                                            ?>
                                        <a class="motoa" href="confirm.php" title="Click Here To Go For Confirmation Of All Products">Go To Confirmation&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>
                                        <?php
                                        }
                                        ?>
                                    
                                    </td>
                                </tr>
                            </table>
                                <?php    
                                }
                                ?>
                                     
<?php
}
?>



<!-- Product Confirmation-->

<?php
if(@$_REQUEST['kona']=="confirmcart")
{
    
?>
    <table class="table table-responsive table-bordered mis">
                                <tr>
                                    <th>No.</th>
                                    <th>Product image</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Discount(%)</th>
                                    <th>Grand Total</th>
                                </tr>
                                <?php
                                $c=0;
                                $data=  mysqli_query($con,"select * from cart where userid like '$_SESSION[user]'");
                                while($data1=  mysqli_fetch_array($data))
                                {
                                    $c++;
                                    $pro=  mysqli_query($con,"select imagepath,petasubcatid,description,measureid from productmaster where productid=$data1[1]");
                                    $pro1=  mysqli_fetch_array($pro);
                                    $proname=  mysqli_query($con,"select petasubcatname from petasubcategory where petasubcatid=$pro1[1]");
                                    $proname1=  mysqli_fetch_array($proname);
                                    $selm=  mysqli_query($con,"select measure from measure where measureid=$pro1[3]");
                                    $selm1=  mysqli_fetch_array($selm);
                                   
                                ?>
                               
                                    <tr>
                                        <td class="f"><?php echo $c; ?></td>
                                        <td><img src="<?php echo $pro1[0]; ?>" style="width: 100%;height: 30%;" class="img img-responsive"/></td>
                                        <td><?php echo $proname1[0];?></td>
                                        <td>
                                            <?php
                                            echo $pro1[2];
                                            ?>
                                        </td>
                                        <td>&#8377;&nbsp;<?php $a=ceil(($data1[4]*$data1[6])/100);echo $b=$a+$data1[4];?></td>
                                        <td><?php echo $data1[3]; ?><font style="text-transform: capitalize;"><br/><?php echo $selm1[0]; ?></font></td>
                                        <td><?php echo $data1[6];?>.00</td>
                                        <td>&#8377;&nbsp;<?php echo $data1[7];?></td>
                                        
                                       
                                    </tr>
                               
                                <?php
                                }
                                ?>
                                <tr style="background: #eee;">
                                    <td colspan="8" style="border-right: none;">
                                        <font>Total Confirmation Products Are : <?php echo $c; ?></font>
                                    
                                        <br/>
                                        
                                        <a class="motoa" href="addtocart.php" title="Click Here To Go For My cart"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go To My Cart</a>&nbsp;|
                                        <a class="motoa" href="checkout.php" title="Click Here To Go For Shipping">Go To Shipping&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>
                                  </td>
                                </tr>
                            </table>     
<?php
}
?>



<?php
if(@$_REQUEST['kona']=="missship")
{
    if(@$_REQUEST['shu']!=0)
    {
        $_SESSION['alr']=1;
        $gsh=  mysqli_query($con,"select * from shipping where shippingid=$_REQUEST[shu]");
        $gsh1=  mysqli_fetch_array($gsh);
    }
?>
<table class="table table-responsive fillship regtable">
                                            
    <tr>
    <td>
        <select class="form-control reginput" name="selcity" required="">
        <option value="">--Select City--</option>
        <?php
        $sel=  mysqli_query($con,"select *from city where citydel=0");
        while($sel1=  mysqli_fetch_array($sel))
        {
            if($gsh1[2]==$sel1[0])
            {
        ?>
        <option selected="" value="<?php echo $sel1[0]; ?>"><?php echo $sel1[1]; ?></option>
        <?php
            }
            else
            {
        ?>
        <option value="<?php echo $sel1[0]; ?>"><?php echo $sel1[1]; ?></option>
        <?php
            }
        }
        ?>
    </select>
    </td>
    </tr>

    <tr>
    <td>
        <input type="text" style="border: none;border-bottom: 1px solid #01c38e;" name="address" placeholder="Your Shipping Address..." class="form-control reginput" value="<?php echo @$gsh1[4]; ?>" required=""/>
    </td>
    </tr>
    <tr>
    <td>
        <input type="text" style="border: none;border-bottom: 1px solid #01c38e;" name="mobile" placeholder="E.g.8758441385" class="form-control reginput" value="<?php echo @$gsh1[5]; ?>" required=""/>
    </td>
    </tr>
    <tr>
    <td>
        <input type="text" name="pincode" style="border: none;border-bottom: 1px solid #01c38e;" placeholder="E.g.395006" class="form-control reginput" value="<?php echo @$gsh1[3]; ?>" required=""/>
    </td>
    </tr>
</table>   
<?php
}
?>




<!-- Miss Product Bill Of User Side-->

<?php
if(@$_REQUEST['kona']=="misspbill")
{
    
        if(@$_REQUEST['shu']=="last")
        {
            $selbill=  mysqli_query($con,"select * from probill where billid=(select max(billid) from probill where userid like '$_SESSION[user]')");
        }
        if(@$_REQUEST['shu']=="billno")
        {
            $selbill=  mysqli_query($con,"select * from probill where billid=$_REQUEST[data] and userid like '$_SESSION[user]'");
        }
        if(@$_REQUEST['shu']=="bdate")
        {
            $selbill=  mysqli_query($con,"select * from probill where bdate like '$_REQUEST[data]' and userid like '$_SESSION[user]'");
        }
            while($selbill1=  mysqli_fetch_array($selbill))
            {
            $selreg=  mysqli_query($con,"select * from registration where userid like '$selbill1[1]'");
            $selreg1=  mysqli_fetch_array($selreg);
            $selcity=  mysqli_query($con,"select cityname from city where cityid=$selbill1[10]");
            $selcity1=  mysqli_fetch_array($selcity);
            $selt=  mysqli_query($con,"select * from transaction where billid=$selbill1[0]");
            $selt1=  mysqli_fetch_array($selt);
            $selp=  mysqli_query($con,"select * from productmaster where productid=$selt1[3]");
            $selp1=  mysqli_fetch_array($selp);
            $selservicea=  mysqli_query($con,"select s.businessname,s.address,s.registrationno,c.cityname,a.areaname from servicesassign s,city c,area a where assignid=$selp1[1] and c.cityid=s.cityid and a.areaid=s.areaid");
            $selservicea1=  mysqli_fetch_array($selservicea);
            

            ?>
            <div class="col-md-8 col-md-offset-2 proimg" style="margin-top: 3%;">
                <table class="table table-responsive table-bordered">

                    <tr style="background: #eee; ">
                        <td colspan="6" style="text-align: center;"><font style="font-size: 20px;color:#1b1b1b;">RETAIL INVOICE</font></td>
                    </tr>
                    <tr  style="font-size: 14px;">
                        <td colspan="6" style="letter-spacing: 2px;line-height: 0.5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/line.png"  style="width: 21%;height: 12%;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/HOME 01.png" style="width:18%;height:8%; "/><br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo rand(000111, 556990);?><?php echo rand(10999, 99999);?><?php echo rand(22111,98888);?>
                        </td>

                    </tr>
                    <tr  style="font-size: 14px;">
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">INVOICE NUMBER :</font> <?php echo $selbill1[0]; ?></td>
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">INVOICE DATE :</font> 
                        <?php 
                            $dt=substr($selbill1[2],8,2);
                            $mn=substr($selbill1[2],5,2);
                            $yr=substr($selbill1[2],0,4);
                            echo $dt."-";
                            echo $mn."-";
                            echo $yr;
                            
                            ?>
                        </td>
                    </tr>
                    <tr style="background: #eee;border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">SELLER</font> </td>
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">BUYER</font></td>
                    </tr>
                    <tr  style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;text-transform: capitalize;">
                        <td colspan="3">
                        <font style="font-size: 14px;color:#1b1b1b;">Happy Home Services<br/>
                        B-201,Astha Square, Utran Road,Varachha<br/>
                        City :&nbsp;Surat<br/> Area :&nbsp;Utran<br/>
                        Registration No :&nbsp;146775-HAPPY-334
                        </font> 
                        </td>
                        <td colspan="3">
                        <font style="font-size: 14px;color:#1b1b1b;">
                         <?php echo $selreg1[0]; ?>   <br/>
                       <?php echo $selbill1[5]; ?><br/>
                       City : &nbsp;<?php echo $selcity1[0]; ?> <br/>
                       Pin Code :&nbsp;<?php echo $selbill1[8]; ?><br/>
                       Mobile :&nbsp;<?php echo $selbill1[9]; ?>
                        </font>
                        </td>

                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;background: #eee;">
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">S.NO</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">ITEM DESCRIPTION</font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">QTY</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">RATE</font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">DISCOUNT(%)</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">AMOUNT</font></td>
                        

                    </tr>
                    <?php
                    $c=0;
                    $seltransaction=  mysqli_query($con,"select * from transaction where billid=$selbill1[0]");
                    while($seltransaction1=  mysqli_fetch_array($seltransaction))
                    {
                        $selproduct=  mysqli_query($con,"select petasubcatid,assignid,measureid from productmaster where productid=$seltransaction1[3]");
                        $selproduct1=  mysqli_fetch_array($selproduct);
                        $selser=  mysqli_query($con,"select businessname from servicesassign where assignid=$selproduct1[1]");
                        $selser1=  mysqli_fetch_array($selser);
                        $selpeta=  mysqli_query($con,"select petasubcatname from petasubcategory where petasubcatid=$selproduct1[0]");
                        $selpeta1=  mysqli_fetch_array($selpeta); 
                        $selm=  mysqli_query($con,"select measure from measure where measureid=$selproduct1[2]");
                        $selm1=  mysqli_fetch_array($selm);
                        $c++;
                    ?>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;text-transform: capitalize;">
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $c;?></font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $selpeta1[0]; ?><br/><?php echo $selbill1[6]; ?><br/>
                            Seller&nbsp;:<br/>
                            <?php echo $selser1[0]; ?>
                            </font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $seltransaction1[4]; ?><br/><?php echo $selm1[0]; ?></font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;">Rs.<?php $a=ceil(($seltransaction1[5])*2/100); echo $a+$seltransaction1[5] ?></font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $seltransaction1[7]; ?>.00</font><br/>
                            
                            </font>
                        </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;">Rs.<?php echo $seltransaction1[6]; ?></font></td>
                        

                    </tr>
                    <?php
                    }
                    ?>
                    <?php
                    if($selbill1[11]!=0)
                    {
                        ?>
                    <tr>
                        <td colspan="6" style="text-align: center;"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">Extra Coupen Discount On Product : </font>Rs. <?php echo $selbill1[11]; ?></td> 
                    </tr>
                    <?php
                    }
                    ?>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;font-size: 14px;">
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">SHIPPING CHARGE : </font>Rs. <?php echo $selbill1[3]; ?></td>
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">SERVICE TAX : </font>Rs.<?php echo $st=ceil((($selbill1[7])*2)/100); ?>(2.00%)</td>
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">TOTAL : </font>Rs. &nbsp;<?php echo $selbill1[7]; ?></td>
                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="6">
                            <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">DECLARATION</font><br/>
                            <font style="font-size: 14px;color:#1b1b1b;">We declare that this invoice shows actual price of goods and that all particulars are true and correct.</font><br/>
                        <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">CUSTOMER ACKNOWLEDGEMENT--</font><br/>
                        <font style="font-size: 14px;color:#1b1b1b;">I <font style="text-transform: uppercase;"><?php echo $selreg1[0]; ?></font> hereby confirm that the above said products are being purchased for my internal / personal consumption and not for re-sale.</font>
                        </td>
                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="5">
                            <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE</font>
                        </td>
                        <td colspan="1" style="background: #eee;">
                            <font onclick="adminproductmbill();" style="font-size: 14px;color: #1b1b1b;cursor: pointer;">Print Invoice</font>
                        </td>
                    </tr>    
                </table> 
            </div>
            <?php
            }
}                    
?>




<!-- Miss Product Bill Of service Provider Side-->



<?php
if(@$_REQUEST['kona']=="sellerbill")
{
    
    if(@$_REQUEST['data']!='0')
    {
        if(@$_REQUEST['shu']=="seller")
        {
            $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and t.productid in (select productid from productmaster where assignid=$_REQUEST[data])");
            $kk=  mysqli_query($con,"select count(*) from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and t.productid in (select productid from productmaster where assignid=$_REQUEST[data])");
            $kk1=  mysqli_fetch_array($kk);
        }
        if(@$_REQUEST['shu']=="billno")
        {
          
            $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.billid=$_REQUEST[data] and s.userid like '$_SESSION[user]'");
            $kk=  mysqli_query($con,"select count(*),s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.billid=$_REQUEST[data] and s.userid like '$_SESSION[user]'");
            $kk1=  mysqli_fetch_array($kk);
        }
        if(@$_REQUEST['shu']=="user")
        {
            $k1= mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and t.userid like '$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
            $kk= mysqli_query($con,"select count(*),s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and t.userid like '$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
            $kk1=  mysqli_fetch_array($kk);
        
        }
        if(@$_REQUEST['shu']=="payment")
        {
         $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.paymentmethod='$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
         $kk=  mysqli_query($con,"select count(*),s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.paymentmethod='$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
         $kk1=  mysqli_fetch_array($kk);
        }
        if(@$_REQUEST['shu']=="bdate")
        {
         $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.bdate='$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
         $kk=  mysqli_query($con,"select count(*),s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.bdate='$_REQUEST[data]' and s.userid like '$_SESSION[user]'");
         $kk1=  mysqli_fetch_array($kk);
        }
        if(@$_REQUEST['shu']=="lprice" || @$_REQUEST['shu']=="hprice")
        {
            if(@$_REQUEST['lp']=="" && @$_REQUEST['hp']!="")
            {
                $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.finalamount between 0 and $_REQUEST[hp] and s.userid like '$_SESSION[user]'");
                $kk=  mysqli_query($con,"select count(*) from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.finalamount between 0 and $_REQUEST[hp] and s.userid like '$_SESSION[user]'");
                $kk1=  mysqli_fetch_array($kk);
               
            }
            if(@$_REQUEST['lp']!="" && @$_REQUEST['hp']!="")
            {
                $k1=  mysqli_query($con,"select s.userid,s.assignid,t.*,b.* from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.finalamount between $_REQUEST[lp] and $_REQUEST[hp] and s.userid like '$_SESSION[user]'");
               $kk=  mysqli_query($con,"select count(*) from probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and b.finalamount between 0 and $_REQUEST[hp] and s.userid like '$_SESSION[user]'");
                $kk1=  mysqli_fetch_array($kk);
            }
        }

    }
    
    

if(@$kk1[0]!=0)
{
    while($k2=  mysqli_fetch_array($k1)){
    
            $selreg=  mysqli_query($con,"select * from registration where userid like '$k2[4]'");
            $selreg1=  mysqli_fetch_array($selreg);
            $selcity=  mysqli_query($con,"select cityname from city where cityid=$k2[21]");
            $selcity1=  mysqli_fetch_array($selcity);
            $selp=  mysqli_query($con,"select * from productmaster where productid=$k2[5]");
            $selp1=  mysqli_fetch_array($selp);
            $selservicea=  mysqli_query($con,"select s.businessname,s.address,s.registrationno,c.cityname,a.areaname from servicesassign s,city c,area a where assignid=$selp1[1] and c.cityid=s.cityid and a.areaid=s.areaid");
            $selservicea1=  mysqli_fetch_array($selservicea);

            ?>
            <div class="col-md-8 col-md-offset-2 proimg" style="margin-top: 3%;">
                <table class="table table-responsive table-bordered">

                    <tr style="background: #eee; ">
                        <td colspan="6" style="text-align: center;"><font style="font-size: 20px;color:#1b1b1b;">RETAIL INVOICE</font></td>
                    </tr>
                    <tr  style="font-size: 14px;">
                        <td colspan="6" style="letter-spacing: 2px;line-height: 0.5;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/line.png"  style="width: 21%;height: 12%;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/HOME 01.png" style="width:18%;height:8%; "/><br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo rand(000111, 556990);?><?php echo rand(10999, 99999);?><?php echo rand(22111,98888);?>
                        </td>

                    </tr>
                    <tr  style="font-size: 14px;">
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">INVOICE NUMBER :</font> <?php echo $k2[11]; ?></td>
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">INVOICE DATE :</font> 
                            <?php 
                            $dt=substr($k2[13],8,2);
                            $mn=substr($k2[13],5,2);
                            $yr=substr($k2[13],0,4);
                            echo $dt."-";
                            echo $mn."-";
                            echo $yr
                                    
                            ?>
                        </td>
                    </tr>
                    <tr style="background: #eee;border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">SELLER</font> </td>
                        <td colspan="3"><font style="font-size: 14px;font-weight: bold;color:#1b1b1b;">BUYER</font></td>
                    </tr>
                    <tr  style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;text-transform: capitalize;">
                        <td colspan="3">
                        <font style="font-size: 14px;color:#1b1b1b;">Happy Home Services<br/>
                        B-201,Astha Square, Utran Road,Varachha<br/>
                        City :&nbsp;Surat<br/> Area :&nbsp;Utran<br/>
                        Registration No :&nbsp;146775-HAPPY-334
                        </font> 
                        </td>
                        <td colspan="3">
                        <font style="font-size: 14px;color:#1b1b1b;">
                         <?php echo $selreg1[0]; ?>   <br/>
                       <?php echo $k2[16]; ?><br/>
                       City : &nbsp;<?php echo $selcity1[0]; ?> <br/>
                       Pin Code :&nbsp;<?php echo $k2[19]; ?><br/>
                       Mobile :&nbsp;<?php echo $k2[20]; ?>
                        </font>
                        </td>

                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;background: #eee;">
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">S.NO</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">ITEM DESCRIPTION</font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">QTY</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">RATE</font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">DISCOUNT(%)</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">AMOUNT</font></td>
                        

                    </tr>
                    <?php
                    $c=0;
                    $seltransaction=  mysqli_query($con,"select * from transaction where transactionid=$k2[2]");
                    while($seltransaction1=  mysqli_fetch_array($seltransaction))
                    {
                        $selproduct=  mysqli_query($con,"select petasubcatid,measureid from productmaster where productid=$seltransaction1[3]");
                        $selproduct1=  mysqli_fetch_array($selproduct);
                        $selpeta=  mysqli_query($con,"select petasubcatname from petasubcategory where petasubcatid=$selproduct1[0]");
                        $selpeta1=  mysqli_fetch_array($selpeta); 
                        $selm=  mysqli_query($con,"select measure from measure where measureid=$selproduct1[1]");
                        $selm1=  mysqli_fetch_array($selm);
                        $c++;
                    ?>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;text-transform: capitalize;">
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $c;?></font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $selpeta1[0]; ?><br/><?php echo $k2[17]; ?></font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $seltransaction1[4]; ?><br/><?php echo $selm1[0]; ?></font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php $a=ceil(($seltransaction1[5])*2/100); echo $a+$seltransaction1[5] ?></font></td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $seltransaction1[7]; ?>.00%</font> </td>
                        <td><font style="font-size: 14px;color:#1b1b1b;"><?php echo $seltransaction1[6]; ?></font></td>
                        

                    </tr>
                    <?php
                    }
                    ?>
                    <?php
                    if(@$k2[22]!=0)
                    {
                        ?>
                    <tr>
                        <td colspan="6" style="text-align: center;"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">Extra Coupen Discount On Product : </font>Rs. <?php echo $k2[22]; ?></td> 
                    </tr>
                    <?php
                    }
                    ?>
                    <?php
                    $selt=  mysqli_query($con,"select * from transaction where transactionid=$k2[2]");
                    $selt1=  mysqli_fetch_array($selt);
                    ?>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;font-size: 14px;">
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">SHIPPING CHARGE : </font> <?php echo $k2[14]; ?></td>
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">SERVICE TAX : </font>Rs. &nbsp;<?php $a=(($selt1[8])+$k2[14]);echo $b=ceil(($a*2)/100);?></td>
                        <td colspan="2"><font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">TOTAL : </font>Rs. &nbsp;<?php $a=$selt1[8]-$k2[22]+$k2[14]; $b=($a*$k2[15])/100; echo ceil($a+$b);?></td>
                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="6">
                            <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">DECLARATION</font><br/>
                            <font style="font-size: 14px;color:#1b1b1b;">We declare that this invoice shows actual price of goods and that all particulars are true and correct.</font><br/>
                        <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">CUSTOMER ACKNOWLEDGEMENT--</font><br/>
                        <font style="font-size: 14px;color:#1b1b1b;">I <?php echo $selreg1[0]; ?> hereby confirm that the above said products are being purchased for my internal / personal consumption and not for re-sale.</font>
                        </td>
                    </tr>
                    <tr style="border-bottom:1px solid #1b1b1b;border-top: 1px solid #1b1b1b;">
                        <td colspan="5">
                            <font style="font-size: 14px;color:#1b1b1b;font-weight: bold;">THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE</font>
                        </td>
                        <td colspan="1" style="background: #eee;">
                            <font onclick="adminproductbill();" style="font-size: 14px;color: #1b1b1b;cursor: pointer;">Print Invoice</font>
                        </td>
                    </tr>    
                </table> 
            </div>
            <?php
            }
}   
else
{
?>
<div class="animated shakestart">
<center style="padding-top: 4%;"><font style="color:red;font-size: 100px;"><i class="fa fa-warning"></i></font></center>
<center><font style="color:red;font-size: 30px;">No Bill Found</font></center><br/><br/>
</div>
    <?php
}
}                   
?>



<!-- Service Provider Side Product MIS-->

<?php    
if(@$_REQUEST['kona']=="seapackproduct")
{
?>    
<table class="table table-responsive table-bordered mis">
                            <tr>
                            <th>No.</th>
                            <th>Member Name</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Date</th>
                            </tr>
                      <?php
                      $c=0;
                      if(@$_REQUEST['koni']=="badhu")
                      {
                        $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="mname")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]' and r.username like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="pname")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]' and ps.petasubcatname like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="qty")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]' and t.qty like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="amount")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]' and t.grandtotal like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="date")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username from registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and s.userid like '$_SESSION[user]' and b.bdate like '$_REQUEST[shu]%'");
                      }
                      while($row1=  mysqli_fetch_array($data1))
                      {
                          $c++;
                              ?>
                        
                        
                            <tr>
                                <td class="f" titile="<?php echo $c; ?>"><?php echo $c; ?></td>
                                <td><?php echo $row1[39]; ?></td>
                                <td><?php echo $row1[38]; ?></td>
                                <td><?php echo $row1[6]; ?></td>
                                <td><?php echo $row1[10]; ?></td>
                                <td><?php echo $row1[13]; ?></td>
                            </tr>
                       
                                
                        <?php
                          
                      }
                      ?>
                            <tr>
                                <td colspan="3" class="f">
                                    Total Package MIS Record Are : <?php echo $c; ?>
                                </td>
                                <td colspan="3" class="f">
                                    <font onclick="adpackmis();">Print Here To Print MIS Record..!</font>
                                </td>
                            </tr>
                            
                            
                            
                            
                             </table>
 <?php
 }
 ?>



<!-- Member Side Product MIS-->

<?php    
if(@$_REQUEST['kona']=="seapackproductm")
{
?>    
<table class="table table-responsive table-bordered mis">
                            <tr>
                            <th>No.</th>
                            <th>Member Name</th>
                            <th>Product Name</th>
                            <th>Seller</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Date</th>
                            </tr>
                      <?php
                      $c=0;
                      if(@$_REQUEST['koni']=="badhu")
                      {
                        $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]'");
                      }
                      if(@$_REQUEST['koni']=="mname")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]' and r.username like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="pname")
                      {
                          
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]' and ps.petasubcatname like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="qty")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]' and sa.businessname like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="amount")
                      {
                           $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]' and t.grandtotal like '$_REQUEST[shu]%'");
                      }
                      if(@$_REQUEST['koni']=="date")
                      {
                          $data1=mysqli_query($con,"select s.userid,s.assignid,t.*,b.*,p.*,ps.petasubcatname,r.username,sa.businessname from servicesassign sa,registration r,petasubcategory ps, probill b,transaction t,servicesassign s,productmaster p where p.productid=t.productid and s.assignid=p.assignid and b.billid=t.billid and ps.petasubcatid=p.petasubcatid and t.userid=r.userid and sa.assignid=p.assignid and t.userid like '$_SESSION[user]' and b.bdate like '$_REQUEST[shu]%'");
                      }
                      while($row1=  mysqli_fetch_array($data1))
                      {
                          $c++;
                              ?>
                        
                        
                            <tr>
                                <td class="f" titile="<?php echo $c; ?>"><?php echo $c; ?></td>
                                <td><?php echo $row1[39]; ?></td>
                                <td><?php echo $row1[38]; ?></td>
                                <td><?php echo $row1[40]; ?></td>
                                <td><?php echo $row1[6]; ?></td>
                                <td><?php echo $row1[10]; ?></td>
                                <td><?php echo $row1[13]; ?></td>
                            </tr>
                       
                                
                        <?php
                          
                      }
                      ?>
                            <tr>
                                <td colspan="3" class="f">
                                    Total Package MIS Record Are : <?php echo $c; ?>
                                </td>
                                <td colspan="4" class="f">
                                    <font onclick="adpackmis();">Print Here To Print MIS Record..!</font>
                                </td>
                            </tr>
                            
                            
                            
                            
                             </table>
 <?php
 }
 ?>


<?php
if(@$_REQUEST['kai']=="book")
{
    
  if(@$_REQUEST['val']!=0)
  {
      $sel=mysqli_query($con,"select verify from servicesbook where bookid=$_REQUEST[val]");
      $sel1=  mysqli_fetch_array($sel);
     
      if(@$sel1[0]==0)
      {
          mysqli_query($con,"update servicesbook set verify=1 where bookid=$_REQUEST[val]");
      }
      if(@$sel1[0]==1)
      {
         
          mysqli_query($con,"update servicesbook set verify=2 where bookid=$_REQUEST[val]");
      }
       
      if(@$sel1[0]==2)
      {
          mysqli_query($con,"delete from servicesbook where bookid=$_REQUEST[val]");
      }
    
      
      
  }
    
?>
    <div class="col-md-10 col-md-offset-1">

                        <?php
                        $sel=  mysqli_query($con,"select *from servicesassign where userid like '$_SESSION[user]'");
                        while($sel1=  mysqli_fetch_array($sel))
                        {
                            ?>
                        <fieldset><legend style="text-transform: capitalize;"><?php echo $sel1[3]; ?></legend></fieldset>
                        <div class="row" style="padding-top: 3%;">
                            <div class="col-md-10 col-md-offset-1">
                                <table class="table table-responsive table-bordered mis">
                                    <tr>
                                        <th>No.</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>City</th>
                                        <th>Pin code</th>
                                        <th>verify</th>
                                        <th>Delete</th>
                                    </tr>
                                    
                            <?php
                            $c=0;
                                $cu=  mysqli_query($con,"select sb.*,r.profile,r.username,c.cityname,sa.* from servicesbook sb,servicesassign sa,registration r,city c where sa.assignid=sb.assignid and  sa.userid like '$_SESSION[user]' and sb.userid=r.userid and c.cityid=sb.cityid and sa.assignid=$sel1[0]");
                                while($cuu=  mysqli_fetch_array($cu))
                                {
                                    $c++;
                                 ?>   
                        
                                                                        
                                    <tr>
                                        <td class="f"><?php echo $c; ?></td>
                                        <td><img src="<?php echo $cuu[9]; ?>" style="width:40px;height: 40px; "  /></td>
                                        <td><?php echo $cuu[10]; ?></td>
                                        <td><?php echo $cuu[4]; ?></td>
                                        <td><?php echo $cuu[6]; ?></td>
                                        <td><?php echo $cuu[11]; ?></td>
                                        <td><?php echo $cuu[8]; ?></td>
                                       
                                        <?php
                                        if($cuu[5]==0)
                                        {
                                       ?>
                                        <td style="color:red;" onclick="servicebook('book',<?php echo $cuu[0]; ?>);">Pending</td>
                                        <?php
                                        }
                                        if($cuu[5]==1)
                                        {
                                        ?>
                                        <td style="color:green;" onclick="servicebook('book',<?php echo $cuu[0]; ?>);">Active</td>
                                        <?php
                                        }
                                        if($cuu[5]==2)
                                        {
                                        ?>
                                        <td style="color:blue;" onclick="servicebook('book',<?php echo $cuu[0]; ?>);">Finish</td>
                                        <?php
                                        }
                                        ?>
                                        
                                        
                                        
                                        <td onclick="servicebook('book',<?php echo $cuu[0]; ?>);"><font><i class="fa fa-close"></i></font></td>
                                    </tr>
                                <?php    
                                }
                                ?>
                                    <tr>
                                        <td colspan="9" class="f">
                                            Total Contacts In <font style="text-transform: capitalize;"><?php echo $sel1[3]; ?></font> Are : <?php echo $c; ?>
                                        </td>
                                    </tr>     
                                </table>
                            </div>
                            
                        </div>
                        <?php
                        }
                       
                        ?>
                    </div>
<?php
}
?>