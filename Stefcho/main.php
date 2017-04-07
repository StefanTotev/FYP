<?php
date_default_timezone_set('Etc/UTC');
error_reporting(1);

include_once('config.php');
  
$errors = array();  
$success = array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Habituo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div>
    </div>
</nav>

<div id="myCarousel" class="carousel slide">
    <ol class="carousel-indicators">
        
    </ol>

    <div class="carousel-inner">
        
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container-fluid">
    
        <div class="col-sm-12">
            <h1 class="page-header">Dashboard</h1>

            <div class="row placeholders">

                <div class="col-xs-12 col-sm-12 placeholder">
                    <h2><br/>Progress for each website compared to overall specified time for today<br/></h2>
                    <div class="dropdown" style="text-align:center;height:50px;">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="websiteDropdown1">
                            Website <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="dropDownMenu2" style="margin:10px auto; left:50%; margin-left:-80px; text-align:center;">
                            <li class="dropdown-header"></li>
                        </ul>
                    </div>

                    <div class="progress" id="progressBarResult1">
                        
                    </div>
                </div>
                
                <h2><br/>Overall Website Use<br/></h2>
                <div class="dropdown" style="text-align:center;height:50px;">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="dateDropdown">
                        Date <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="dropDownMenu1" style="margin:10px auto; left:50%; margin-left:-80px; text-align:center;">
                        <li class="dropdown-header"></li>
                    </ul>
                </div>
                <div class="col-xs-6 col-sm-6 placeholder">
                    <h3 style="height:50px;">Positive vs Negative</h3>
                    <div class="col-xs-6 col-sm-6 placeholder">
                        <span style="font-size: 25px" class="glyphicon glyphicon-time"></span>
                        <canvas id="pieChartTime1"></canvas>
                        <h4>Time</h4>
                        <span class="text-muted">Comparison of overall spent time</span>
                    </div>
                    <div class="col-xs-6 col-sm-6 placeholder">
                        <span style="font-size: 25px" class="glyphicon glyphicon-ban-circle"></span>
                        <canvas id="pieChartAccess1"></canvas>
                        <h4>Number of Accesses</h4>
                        <span class="text-muted">Comparison of overall numbers of access</span>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 placeholder">
                    <h3 style="height:50px;">Today's Overall Website Use</h3>
                    <div class="col-xs-6 col-sm-6 placeholder">
                        <span style="font-size: 25px" class="glyphicon glyphicon-time"></span>
                        <canvas id="pieChartTime2"></canvas>
                        <h4>Time</h4>
                        <span class="text-muted">Daily representation of separate websites</span>
                    </div>
                    <div class="col-xs-6 col-sm-6 placeholder">
                        <span style="font-size: 25px" class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <canvas id="pieChartAccess2"></canvas>
                        <h4>Number of Accesses</h4>
                        <span class="text-muted">Daily count for separate websites</span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 placeholder">
                    <h2 style="height:50px;"><br/>Overall Website Use<br/></h2>
                    <canvas id="lineChart1"></canvas>
                    <span class="text-muted">Daily representation of separate websites compared to daily targets</span>
                </div>
            </div>

            <h2 class="sub-header"><br/><span style="font-size: 25px" class="glyphicon glyphicon-list"></span> Individual Statistics</h2>
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Website</th>
                        <th>Time</th>
                        <th>Number of Visits</th>
                        <th>Date of Access</th>
                        <th>XP</th>
                    </tr>
                    </thead>
                    <tbody class="someclass">
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="js/holder.min.js"></script>
<script type="text/javascript" src="js/date.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

<script>
    var data;
    var visitedWebsites = [];
    var allWebsites = [];
    var time = [];
    var preferedTime = [];
    var backgroundColor = [];
    var numberOfAccesses = [];
    var currentDate = [];
    var xp = [];
    var webType = [];
    var overallPositiveTime = 0;
    var overallNegativeTime = 0;
    var overallPositiveAccess = 0;
    var overallNegativeAccess = 0;
    var numberOfPositive = 0;
    var positiveWebsites = [];
    var otherWebsitesTime = 0;
    var otherWebsitesAccesses = 0;
    var otherTime = 0;
    var otherAccess = 0;
    var topWebsiteTime = [];
    var topWebsites = [];
    var dates = [];
    var checked = false;
    var myPieChart1, myPieChart2, myPieChart3, myPieChart4;

    var dynamicColors = function(type) {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        if(type == 'rgb'){
            return "rgb( " + r + ", " + g + ", " + b + ")";
        } else if(type == 'rgba') {
            return "rgba( " + r + ", " + g + ", " + b;
        }
    }

    var search = function () {
        // Declare variables 
        var td;
        var input = document.getElementById("input");
        var search = input.value.toUpperCase();
        var table = document.getElementById("table");
        var tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (var i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(search) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
    }
    var sortFuncTime = function (one,two) {
        if (one.dailyTime < two.dailyTime)
            return 1;
            return 0;
        if (one.dailyTime > two.dailyTime)
            return -1;
    }
    var sortFuncAccess = function (one,two) {
        if (one.numberOfAccesses < two.numberOfAccesses)
            return 1;
            return 0;
        if (one.numberOfAccesses > two.numberOfAccesses)
            return -1;
    }
    var changeDate = function (count, date) {
        document.getElementById("dateDropdown").firstChild.data = date;
        createTablesTime(count);
        createTablesAccess(count);
    }
    var changeWebsite = function (number, preferedTime) {
        var progressResult;
            for(var i = 0; i < data[0][4].length; i++) {
                if(data[0][4][i].website == allWebsites[number]) {
                    progressResult = data[0][4][i].dailyTime * 100 / preferedTime;
                }
            }
            if(progressResult > 100) progressResult = 100;
    console.log(progressResult);
        $('#actualProgressBar').css('width', progressResult+'%').attr('aria-valuenow', progressResult); 
    }

    var createTablesTime = function(number) {
        
        visitedWebsites = [];
        time = [];
        otherWebsitesTime = 0;
        overallPositiveTime = 0;
        overallPositiveAccess = 0;
        overallNegativeTime = 0;
        overallNegativeAccess = 0;

        data[0][number].sort(sortFuncTime);
        var websiteUse = data[0][number];

        for(var i in websiteUse) {
            if(i < 4) {
                if(websiteUse[i].website != 'other')visitedWebsites.push(websiteUse[i].website);
                time.push(websiteUse[i].dailyTime);
            } else {
                otherWebsitesTime = otherWebsitesTime + websiteUse[i].dailyTime;
            }

            var index = allWebsites.indexOf(websiteUse[i].website);
            if(index != (-1)) {
                if(webType[index] == 'positive') {
                    overallPositiveTime = overallPositiveTime + websiteUse[i].dailyTime;
                    overallPositiveAccess = overallPositiveAccess + websiteUse[i].numberOfAccesses;
                } else if(webType[index] == 'negative') {
                    overallNegativeTime = overallNegativeTime + websiteUse[i].dailyTime;
                    overallNegativeAccess = overallNegativeAccess + websiteUse[i].numberOfAccesses;
                } else if(webType[index] == 'other') {
                    if(i < 4)visitedWebsites.push("Unselected");
                    otherTime = websiteUse[i].dailyTime;
                    otherAccess = websiteUse[i].numberOfAccesses;
                }
            }
        }
        visitedWebsites.push("Other Selected");
        time.push(otherWebsitesTime);
        if(checked == true) {
            myPieChart1.destroy();
            myPieChart2.destroy();
        }
        var ctx = document.getElementById('pieChartTime1'); 
        var data2 = {
            labels: ["Positive", "Negative", "Unselected"],
            datasets: [
                {
                    data: [overallPositiveTime, overallNegativeTime, otherTime],
                    backgroundColor: [
                        backgroundColor[0],
                        backgroundColor[1],
                        backgroundColor[2]
                    ]
                }]
        };
        myPieChart1 = new Chart(ctx,{
            type: 'doughnut',
            data: data2,
            options: {
                animation:{
                    animateRotate:false
                }
            }
        });

        var ctx = document.getElementById('pieChartTime2'); 
        var data1 = {
            labels: visitedWebsites,
            datasets: [
                {
                    data: time,
                    backgroundColor: backgroundColor
                }]
        };
        myPieChart2 = new Chart(ctx,{
            type: 'doughnut',
            data: data1,
            options: {
                animation:{
                    animateRotate:false
                }
            }
        });
    }

    var createTablesAccess = function (number) {
        visitedWebsites = [];
        numberOfAccesses = [];
        otherWebsitesAccesses = 0;

        data[0][number].sort(sortFuncAccess);
        var websiteUse = data[0][number];

        for(var i in websiteUse) {
            if(i < 4) {
                if(websiteUse[i].website != 'Other')visitedWebsites.push(websiteUse[i].website);
                else visitedWebsites.push("Unselected");
                numberOfAccesses.push(websiteUse[i].numberOfAccesses);
            } else {
                otherWebsitesAccesses = otherWebsitesAccesses + websiteUse[i].numberOfAccesses;
            }
        }
        visitedWebsites.push("Other Selected");
        numberOfAccesses.push(otherWebsitesAccesses);
        if(checked == true) {
            myPieChart3.destroy();
            myPieChart4.destroy();
        }
        var ctx = document.getElementById('pieChartAccess1'); 
        var data4 = {
            labels: ["Positive", "Negative", "Unselected"],
            datasets: [
                {
                    data: [overallPositiveAccess, overallNegativeAccess, otherAccess],
                    backgroundColor: [
                        backgroundColor[0],
                        backgroundColor[1],
                        backgroundColor[2]
                    ]
                }]
        };
        myPieChart3 = new Chart(ctx,{
            type: 'doughnut',
            data: data4,
            options: {
                animation:{
                    animateRotate:false
                }
            }
        });

        var ctx = document.getElementById('pieChartAccess2'); 
        var data3 = {
            labels: visitedWebsites,
            datasets: [
                {
                    data: numberOfAccesses,
                    backgroundColor: backgroundColor
                }]
        };
        myPieChart4 = new Chart(ctx,{
            type: 'doughnut',
            data: data3,
            options: {
                animation:{
                    animateRotate:false
                }
            }
        });
        checked = true;
    }
    
    $(document).ready(function(){
        $.ajax({
        url: "http://localhost/FYP/Stefcho/mainCall.php",
        method: "GET",
        success: function(newData) {

            data = newData;
            var userWebsites = data[1];

            var dynColour;
            for(var i = 0; i < 5; i++) {
                dynColour = dynamicColors('rgb');
                backgroundColor.push(dynColour);
            }

            for(var i in userWebsites) {
                allWebsites.push(userWebsites[i].website);
                preferedTime.push(userWebsites[i].preferedTime);
                webType.push(userWebsites[i].webType);

                if(userWebsites[i].webType == 'positive') positiveWebsites.push(userWebsites[i].website);
            }

            var count = 0;
            for(var i = newData[0].length - 1; i >= 0; i--) {
                dates.push(newData[0][i][0].currentDate);
                if(count == 0) document.getElementById('dateDropdown').firstChild.data = dates[count];
                $('#dropDownMenu1').append('<li><a onclick="changeDate(' + i + ', &quot;' + dates[count] + '&quot;);" id="dropdown' + count + '">' + dates[count] + '</a></li>');
                count = count + 1;
            }

            for(var i = 0; i < data[0].length; i++) {
                for(var j = 0 ; j < data[0][i].length; j++) {
                    if(data[0][i][j].dailyTime != 0) {
                        var tempWeb = data[0][i][j].website;
                        if(data[0][i][j].website == 'other') {
                            tempWeb = 'Other';
                        }
                        var dailyTimeVar = (new Date).clearTime().addSeconds(data[0][i][j].dailyTime).toString('H:mm:ss');
                        $('<tr><td>' + tempWeb + '</td><td>' + dailyTimeVar + '</td><td>' + data[0][i][j].numberOfAccesses + '</td><td>' + data[0][i][j].currentDate + '</td><td>' + data[0][i][j].xp + '</td></tr>').appendTo('.someclass');
                    }
                }
            }

            for(var i = 0; i < positiveWebsites.length; i++) {
                $('<div class="item"><img src="img/blue.jpg"><div class="carousel-caption"><div style="background-color:transparent !important;" class="jumbotron center"><h3>Visit this website!</h3><h1>' + positiveWebsites[i] + '</h1><br /><br /><br /><br /><p>Consider being productive now!</p><p><a class="btn btn-large btn-primary" href="http://' + positiveWebsites[i] + '">Visit this website!</a></p></div></div></div>').appendTo('.carousel-inner');
                $('<li data-target="#myCarousel" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators')
            }

            $('.item').first().addClass('active');
            $('.carousel-indicators > li').first().addClass('active');

            var lineChartData = [];
            for(var i = 0; i < 5; i++) {
                var count = 0;
                for(var j = 0; j < allWebsites.length; j++){
                    //if(allWebsites[i] != 'other')console.log(allWebsites[i] + " " + preferedTime[i]);
                    if(allWebsites[j] != 'other') {
                        if(i == 0) {
                            var tempColor = dynamicColors('rgba');
                            lineChartData.push({label: 'Prefered: ' + allWebsites[j]});
                            lineChartData[count].fill = true;
                            lineChartData[count].lineTension = 0.1;
                            lineChartData[count].backgroundColor = tempColor + ", 0.05)";
                            lineChartData[count].borderColor = tempColor + ", 1)";
                            lineChartData[count].pointHoverBackgroundColor = tempColor + ", 1)";
                            lineChartData[count].pointHoverBorderColor = tempColor + ", 1)";
                            lineChartData[count].data = [preferedTime[j]];

                            count++;
                            lineChartData.push({label: 'Actual: ' + newData[0][i][j].website});
                            lineChartData[count].fill = true;
                            lineChartData[count].lineTension = 0.1;
                            lineChartData[count].backgroundColor = tempColor + ", 0.05)";
                            lineChartData[count].borderColor = tempColor + ", 1)";
                            lineChartData[count].pointHoverBackgroundColor = tempColor + ", 1)";
                            lineChartData[count].pointHoverBorderColor = tempColor + ", 1)";
                            lineChartData[count].data = [newData[0][i][j].dailyTime];
                        } else {
                            lineChartData[count].data.push(preferedTime[j]);
                            count++;
                            lineChartData[count].data.push(newData[0][i][j].dailyTime);
                        }
                        count++;
                    }
                }
            }
            console.log(lineChartData);
            var chartdata1 = {
                labels: dates,
                datasets: lineChartData
            }

            var ctx = document.getElementById('lineChart1');
            var myLineChart1 = new Chart(ctx, {
                type: 'line',
                data: chartdata1,
                options: {
                    showLines: true
                }
            });

            createTablesTime(4);

            createTablesAccess(4);

            for(var i = 0; i < allWebsites.length; i++) {
                if(i == 0) document.getElementById('websiteDropdown1').firstChild.data = allWebsites[i];
                if(allWebsites[i] != 'other') $('#dropDownMenu2').append('<li><a onclick="changeWebsite(' + i + ', ' + preferedTime[i] + ');" id="websiteDropdowns' + i + '">' + allWebsites[i] + '</a></li>');
            }

            var progressResult;
            for(var i = 0; i < newData[0][4].length; i++) {
                if(newData[0][4][i].website == allWebsites[0]) {
                    progressResult = newData[0][4][i].dailyTime * 100 / preferedTime[0];
                }
            }
        if(progressResult > 100) progressResult = 100;
        

            $('#progressBarResult1').append('<div class="progress-bar progress-bar-info" role="progressbar" id="actualProgressBar" aria-valuenow="' + progressResult + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressResult + '%"></div>');
            

            $('#table').DataTable({
                "aaSorting": [[3,'des']]
            });

            /*var ctx = document.getElementById('pieChartTime1'); 
            var chartdata = {
                labels: visitedWebsites,
                datasets : [
                    {
                        label: 'Website Use',
                        backgroundColor: 'rgba(200, 200, 200, 0.75)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: time
                    }
                ]
            };

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });*/

            /*var ctx = document.getElementById('pieChartAccess1'); 
            var rgbaColor1 = dynamicColors("rgba");
            var rgbaColor2 = dynamicColors("rgba");
            var data = {
                labels: websiteUse,
                datasets: [
                    {
                        label: "Indicated Prefered Time",
                        backgroundColor: rgbaColor1 + ", 0.2)",
                        borderColor: rgbaColor1 + ", 1)",
                        pointBackgroundColor: rgbaColor1 + ", 1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: rgbaColor1 + ", 1)",
                        data: [65, 59, 90, 81, 56]
                    },
                    {
                        label: "Actual Usage",
                        backgroundColor: rgbaColor2 + ", 0.2)",
                        borderColor: rgbaColor2 + ", 1)",
                        pointBackgroundColor: rgbaColor2 + ", 1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: rgbaColor2 + ", 1)",
                        data: [28, 48, 40, 19, 96]
                    }
                ]
            };
            new Chart(ctx, {
                type: "radar",
                data: data,
                options: {
                        scale: {
                            reverse: true,
                            ticks: {
                                beginAtZero: true
                            }
                        }
                }
            });*/

        },
        error: function(data) {
            console.log(data);
        }
        });
    });
</script>

</body>
</html>