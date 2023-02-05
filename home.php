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
        // var territory_js_obj = JSON.stringify(JSON.parse(<?php /*echo json_encode($json);*/ ?>));
        // var t = new TreeView(territory_js_obj, 'tree');
        // console.log(territory_js_obj);
        
        var territory_js_obj = JSON.parse(<?php echo json_encode($json); ?>);
        var treeContainer = document.getElementById("tree");
        // console.log(territory_js_obj.data);
        /*for(var i = 0; i < territory_js_obj.data.length; i++) {
          console.log(territory_js_obj.data[i]["id"]);
          console.log(territory_js_obj.data[i]["name"]);
        }*/
        // var t = new TreeView(territory_js_obj, treeContainer);
        /*var territory_js_obj = {
            "data" : [
                {
                "id": "1",
                "name": "Metro Manila",
                "parent": null
                },
                {
                "id": "101",
                "name": "Manila",
                "parent": "1"
                },
                {
                "id": "10101",
                "name": "Malate",
                "parent": "101"
                },
                {
                "id": "10102",
                "name": "Ermita",
                "parent": "101"
                },
                {
                "id": "10103",
                "name": "Binondo",
                "parent": "101"
                },
                {
                "id": "102",
                "name": "Makati",
                "parent": "1"
                },
                {
                "id": "10201",
                "name": "Poblacion",
                "parent": "102"
                },
                {
                "id": "10202",
                "name": "Bel-Air",
                "parent": "102"
                },
                {
                "id": "10203",
                "name": "San Lorenzo",
                "parent": "102"
                },
                {
                "id": "10204",
                "name": "Urdaneta",
                "parent": "102"
                },
                {
                "id": "103",
                "name": "Marikina",
                "parent": "1"
                },
                {
                "id": "10301",
                "name": "Sto Nino",
                "parent": "103"
                },
                {
                "id": "10302",
                "name": "Malanday",
                "parent": "103"
                },
                {
                "id": "10303",
                "name": "Concepcion I",
                "parent": "103"
                },
                {
                "id": "2",
                "name": "CALABARZON",
                "parent": null
                },
                {
                "id": "201",
                "name": "Laguna",
                "parent": "2"
                },
                {
                "id": "20101",
                "name": "Calamba",
                "parent": "201"
                },
                {
                "id": "20102",
                "name": "Sta. Rosa",
                "parent": "201"
                },
                {
                "id": "202",
                "name": "Cavite",
                "parent": "2"
                },
                {
                "id": "20201",
                "name": "Kawit",
                "parent": "202"
                },
                {
                "id": "203",
                "name": "Batangas",
                "parent": "2"
                },
                {
                "id": "20301",
                "name": "Lipa",
                "parent": "203"
                },
                {
                "id": "20302",
                "name": "Tanauan",
                "parent": "203"
                },
                {
                "id": "3",
                "name": "Central Luzon",
                "parent": null
                },
                {
                "id": "301",
                "name": "Bulacan",
                "parent": "3"
                },
                {
                "id": "302",
                "name": "Nueva Ecija",
                "parent": "3"
                },
                {
                "id": "303",
                "name": "Tarlac",
                "parent": "3"
                },
                {
                "id": "304",
                "name": "Pampanga",
                "parent": "3"
                }
            ]
        };*/
        /*
        var sortedTerritories = {};

        for (var i = 0; i < territory_js_obj.data.length; i++) {
          var territory = territory_js_obj.data[i];
          var parent = territory.parent;
        
          if (parent === null) {
            sortedTerritories[territory.id] = {
              name: territory.name,
              children: []
            };
          } else {
            if (!sortedTerritories[parent]) {
              sortedTerritories[parent] = {
                children: []
              };
            }
            sortedTerritories[parent].children.push({
              name: territory.name
            });
          }
        }
        console.log(sortedTerritories);
        */

        var territory_list = {};
        // console.log(territory_list);
        
        territory_js_obj.data.forEach(element => {
          territory_list[element.id] = {name: element.name, parent: element.parent, children: {}};
        });
        
        // console.log(territory_js_obj.data);
        // console.log(territory_list);
        
        var sortedTerritories = {};
        
        Object.keys(territory_list).forEach(key => {
          // console.log(`${key} -> ${territory_list[key].name}`);
        
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
      </script>

      <script>
        /*var tree = [{
          name: 'Vegetables',
          children: []
          }, {
          name: 'Fruits',
          children: [{
            name: 'Apple',
            children: []
          }, {
            name: 'Orange',
            children: []
          }, {
            name: 'Lemon',
            children: []
          }]
          }, {
          name: 'Candy',
          children: [{
            name: 'Gummies',
            children: []
          }, {
            name: 'Chocolate',
            children: [{
            name: 'M & M\'s',
            children: []
            }, {
            name: 'Hershey Bar',
            children: []
            }]
          }, ]
          }, {
          name: 'Bread',
          children: []
        }];
        
        var t = new TreeView(tree, 'tree');*/
      </script>
    </div>

      <!--<script src="js-treeview-master/dist/treeview.min.js">
        // var territory_js_obj = JSON.stringify(JSON.parse(<?php /*echo json_encode($json); */?>));
        // var terriTree = new TreeView(sortedTerritories, treeContainer);
      </script>-->
  </body>

</html>