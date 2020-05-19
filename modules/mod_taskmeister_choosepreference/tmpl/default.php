<?php 
// No direct access
defined('_JEXEC') or die; 
//Displays module output
?>

<script type="text/javascript">
    userPreferredList = [];
    userNotPreferredList = [];
    userMayTryList = [];
    <?php// foreach ($tagList as $key => $value) : ?>
      //  userPreferenceList_JS.push("<?php echo $key; ?>");
    <?php //endforeach; ?>

    //Javascript function to update lists
    updateLists = function(){
        //Get Elements
        var list1 = document.getElementById("userPreferredList");
        var list2 = document.getElementById("userNotPreferredList");
        var list3 = document.getElementById("userMayTryList");
        //Set contents
        list1.innerHTML = userPreferredList;
        list2.innerHTML = userNotPreferredList;
        list3.innerHTML = userMayTryList;
    }

    //Javascript function to select preference
    togglePreference = function(tag){
        var element = document.getElementById(tag); //Set selected element
        if (userPreferredList.includes(tag)){//If exists inside preferred list
            userPreferredList = userPreferredList.filter(item => item !== tag);
            userNotPreferredList.push(tag);
            //Change classes
            element.classList.add("userNotPreferred");
            element.classList.remove("userPreferred");
            element.classList.remove("userMayTry");
            console.log("Added "+tag+" to not preferred list! ");
        }
        else if (userNotPreferredList.includes(tag)){//If exists inside not preferred list
            userNotPreferredList = userNotPreferredList.filter(item => item !== tag);
            userMayTryList.push(tag);
            //Change classes
            element.classList.add("userMayTry");
            element.classList.remove("userNotPreferred");
            element.classList.remove("userPreferred");
            console.log("Added "+tag+" to may try list! ");
        }
        else if (userMayTryList.includes(tag)){//If exists inside may try list
            userMayTryList = userMayTryList.filter(item => item !== tag);
            console.log("Remove "+tag+" from lists! ");
            //Change Classes
            element.classList.remove("userMayTry");
            element.classList.remove("userPreferred");
            element.classList.remove("userNotPreferred");
        }
        else {//If not in any list
            userPreferredList.push(tag);
            console.log("Added "+tag+" to preferred list! ");
            //Change classes
            element.classList.add("userPreferred");
            element.classList.remove("userNotPreferred");
            element.classList.remove("userMayTry");
        }
        updateLists();//Update list display
    }
</script>

<div class="customtext preferenceOptions">
    <?php if ($displayHeader) : ?>
        <h3><?php echo $displayHeader; ?></h3>
    <?php endif; ?>
    <?php if ($displayText) : ?>
        <?php echo $displayText; ?>
    <?php endif; ?>
    <br>List of User Preferred: [<span id = "userPreferredList"></span>]
    <br>List of User Not Preferred: [<span id = "userNotPreferredList"></span>]
    <br>List of User May Try: [<span id = "userMayTryList"></span>]
</div>

<div class="preferenceList">
    <?php foreach ($tagList as $key => $value) : ?>
        <div class="preferenceBox" id="<?php echo $key;?>" onclick="togglePreference('<?php echo $key;?>')">
            <img src="/taskmeisterx/templates/taskmeistertemplate-userpage/images/accountIcon.jpg" width="100%" height="100%" />
            <p class = "preferenceLabel"><?php echo $key; ?>: <?php echo $value; ?> uses</p>
        </div>
    <?php endforeach; ?>
</div>