<?php 
  session_start();
  
  if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
      // User is not authenticated
      header("Location: login.php");
      exit;
  }
  
  $json = file_get_contents('https://netzwelt-devtest.azurewebsites.net/Territories/All');
?>

<DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="js-treeview-master/dist/treeview.min.css" />
    <script src="js-treeview-master/dist/treeview.min.js"></script>
  </head>

  <body>
    <div class="home-container">
      <h2>Welcome home!</h2>

      <div id="tree"></div>

      <script>
        var territory_js_obj = JSON.parse(<?php echo json_encode($json); ?>);
        var treeContainer = document.getElementById("tree");

        var territory_list = {};
        
        territory_js_obj.data.forEach(element => {
          territory_list[element.id] = {name: element.name, parent: element.parent, children: {}};
        });
        
        var sortedTerritories = {};
        
        Object.keys(territory_list).forEach(key => {
        
          if(territory_list[key].parent === null) {
            // console.log(`Root key found: ${territory_list[key].name}`);
        
            sortedTerritories[key] = {
              name: territory_list[key].name,
              parent: territory_list[key].parent,
              children: territory_list[key].children
            };
          }
          else {
            sortedTerritories = insertTerritory(key, territory_list[key], sortedTerritories);
          }
        });
          
        console.log(sortedTerritories);

        var territory_hierarchy;
        
        // -------- buildTree won't build, keeps returning object error -----------------
        // Object.keys(sortedTerritories).forEach(element => {
        //   territory_hierarchy += buildTree(element);
        // });
        // treeContainer.innerHTML = territory_hierarchy;

        function insertTerritory(key, territory_entry, sortedTerritories) {
        
          var targetKey = key;
          var tempTargetKey = targetKey;
          var parentKeyLocation = [];
          // var sortedTerritories = sortedTerritories;
        
          // get the location of the parent node
          do {
            tempTargetKey = tempTargetKey.substring(0, tempTargetKey.length-2);
            parentKeyLocation.unshift(tempTargetKey);
          } while(tempTargetKey.length > 2);
        
          // console.log(parentKeyLocation);
        
          // access the parent node's location
        
          if(parentKeyLocation.length === 1){
            sortedTerritories[parentKeyLocation[0]].children[key] = territory_entry;
          }
          else {
            var sortedTerritoriesTarget = sortedTerritories[parentKeyLocation[0]];
            // console.log("Hi there xy " + sortedTerritoriesTarget["name"]);
            for(var i=1; i<parentKeyLocation.length; i++){
              sortedTerritoriesTarget = sortedTerritoriesTarget.children[parentKeyLocation[i]];
              // console.log("Hi there abc " + sortedTerritoriesTarget["name"]);
              // console.log(typeof sortedTerritoriesTarget.children);
              // console.log(typeof sortedTerritoriesTarget);
              if(i === parentKeyLocation.length-1){
                sortedTerritoriesTarget.children[key] = territory_entry;
              }
            }
          }
        
          return sortedTerritories;
        }

        function buildTree(territory) {
          var innerTerritories = "";
          
          if(Object.keys(territory.children).length === 0){
            return `<li>${territory.name}</li>`;
          }
          else {
            Object.keys(territory.children).forEach(element => {
              innerTerritories += buildTree(element);
            });

            return innerTerritories = `<ul>${innerTerritories}</ul>`;
          }
        }
      </script>
    </div>
  </body>

</html>