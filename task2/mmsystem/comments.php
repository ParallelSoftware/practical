<?
function showcomments($ID,$wht)
{
    global $CN;    
    
    if($wht=="Q")
    {
        $add = "AND bcQID='".$ID."'";
    }
    else
    {
        $add = "AND bcBID='".$ID."'";
    }
    $z = mysqli_query($CN["dbl"],"SELECT bcID,bcComment,bcDate,bcFlagged,uID,uNick,uFlagged FROM blogcmnt,users WHERE bcUID=uID ".$add." ORDER BY bcID DESC ");
    if(mysqli_num_rows($z)>0)
    {
        ?>
        <div class="BL_art_dtl_PCH">Previous Comments:</div>
        <?
        while(list($bcID,$bcComment,$bcDate,$bcFlagged,$uID,$uNick,$uFlagged) = mysqli_fetch_array($z))
        {
            if($bcFlagged==1 || $uFlagged==1)
            {
                //flagCAT = 1: blog, 2: Question, 3: Comment, 4: User, 5:Product
                //flagACT = 1: Banned, 2: Deleted, 3: Inactive
                $FLAGARR = array(1 => "Banned", 2 => "Deleted", 3 => "Inactive");
                $flag_yes = checkflag(3,$bcID);
                $flag_yes_usr = checkflag(4,$uID);
                if($FLAGARR[$flag_yes])
                {
                    $flagtxt = " <font color=\"#FF0000\" size=1>[".$FLAGARR[$flag_yes]."]</font>";    
                }
                else
                {
                    $flagtxt = "";    
                }
                if($FLAGARR[$flag_yes_usr])
                {
                    $flagutxt = " <font color=\"#FF0000\" size=1>[".$FLAGARR[$flag_yes_usr]."]</font>";    
                }
                else
                {
                    $flagutxt = "";    
                }
                if($_SESSION["BLOG_ADM"]==1 && ($FLAGARR[$flag_yes] || $FLAGARR[$flag_yes_usr]))
                {
                    $showall = 1;
                }
                elseif($_SESSION["BLOG_ADM"]!=1 && ($FLAGARR[$flag_yes] || $FLAGARR[$flag_yes_usr]))
                {
                    $showall = 2;    
                }             
            }
            else
            {
                $showall = 1;
                $flagtxt = ""; 
                $flagutxt = "";     
            }
            if($showall==1 || $showall!=2)
            {
                if($_SESSION["BLOG_ADM"]==1)
                {
                    $cmnt = "<a href=\"javascript:{}\" onclick=\"blogoptions('".$bcID."',3)\">".stripslashes($bcComment).$flagtxt."</a>";
                    $usr = "<a href=\"javascript:{}\" onclick=\"blogoptions('".$uID."',4)\">".$uNick.$flagutxt."</a>"; 
                }
                else
                {
                    $cmnt = stripslashes($bcComment).$flagtxt;
                    $usr = $uNick.$flagutxt; 
                }
                ?>
                <div class="BL_art_dtl_CMT"><?=$cmnt?></div>
                <div class="BL_art_sml">By: <?=$usr?> on <?=date('d F Y @ h:i',$bcDate)?></div>
                <?    
            }                                    
        }
    }
}

function checkflag($cat,$id)
{
    global $CN;
    //flagCAT = 1: blog, 2: Question, 3: Comment, 4: User, 5:Product
    //flagACT = 1: Banned, 2: Deleted, 3: Inactive
    if($cat && $id)
    {
        $x = mysqli_query($CN["dbl"],"SELECT flagACT FROM flags WHERE flagCAT='".$cat."' AND flagMAINID='".$id."' ORDER BY flagID DESC LIMIT 1");
        if(mysqli_num_rows($x)==1)
        {
            list($flagACT) = mysqli_fetch_row($x); 
            
            return $flagACT;   
        }
        else
        {
            return 0;   
        }        
    }
}