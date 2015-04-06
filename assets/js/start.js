
define (['jquery', 'facebook', 'analyze'], function ($, facebook, Analyze) {

    FB.init({
        appId      : '1468034890110746',
        xfbml      : true,
        status     : true,
        cookie     : true,
        version    : 'v2.2'
    });

    function checkLoginState() {
        FB.getLoginStatus(function (response) { statusChangeCallback(response); });
    }
    
    function statusChangeCallback(response) {
          if (response.status === 'connected') {
              $.get('/analyze', function (res) {
                    Analyze.startAnalyzing();
              });
          } else if (response.status === 'not_authorized') {
             FB.login(function(response) { statusChangeCallback(response); }, {scope: 'user_likes'});
          } else {
             alert("Please login.");
          }
    }
    
    function onStartClick () {
        checkLoginState();
        
        // Hide logo
        $('#logo').animate({
            opacity:0,
            height:0,
            width:0
        },{
            duration: 1000,
            complete: function () { 
                $('#logo').hide();
            } 
        });
        
        // Hide button
        $('#start').animate({
            opacity:0
        },{
            duration: 1000,
            complete: function () { 
                $('#start').hide();
                $('#loading').removeClass('hidden');
            } 
        });
        
    }
    function inviteFriends () {
        // Use FB.ui to send the Request(s)
        FB.ui({method: 'apprequests',
            title: 'Deberías probar esta app',
            message: '\Check out this Awesome App!'
        }, function (){});
   }
   
   function loadLikesChart () {
            google.load('visualization', '1', {packages: ['corechart', 'bar']});
            google.setOnLoadCallback(function () {
                  var data = google.visualization.arrayToDataTable([
                    ['City', '2010 Population'],
                    ['New York City, NY', 8175000],
                    ['Los Angeles, CA', 3792000],
                    ['Chicago, IL', 2695000],
                  ]);

                  var options = {
                    title: 'Population of Largest U.S. Cities',
                    chartArea: {width: '50%'},
                    hAxis: {
                      title: 'Total Population',
                      minValue: 0
                    },
                    vAxis: {
                      title: 'City'
                    },
                      animation: {
                          easing: 'out',
                          delay: 1000,
                          startup: true
                     }
                  };

                  var chart = new google.visualization.BarChart(document.getElementById('likesChart'));
                  chart.draw(data, options);
                } 
            );
     }
    
    // Attach callbacks
    $(document).ready(function () {
        $('#start').click(onStartClick);
        $('#invite').click(inviteFriends);
        $('#likesChart').load(loadLikesChart);
    });
    
});