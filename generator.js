
var img = document.getElementById("sign");
var link = document.getElementById("url");
var data = document.getElementById("data");
var line1 = document.getElementById("line1");
var line2 = document.getElementById("line2");
var type = document.getElementById("type");
var arrow = document.getElementById("arrow");
var hours = document.getElementById("hours");

var tr_metered = document.getElementById("tr_metered");

function update(){
    var url = "parking.php?type="+type.value+"&arrow="+arrow.value+"&data="+data.value.replace(/\n/g,'`');
    if(type.value == 2) url += "&hours="+hours.value;
    img.src = url;
    link.href = url;

    tr_metered.style.display = (type.value=="2"?"":"none");
	
}


function init(){

    var sin = [
	[-1,"Monday - Friday\n8am - 6pm"],
	[-1,"Monday - Friday\n7am - 7pm"],
	[-1,"Monday - Friday\n7am - 10am"],
	[-1,"Monday - Friday\n4pm - 7pm"],
	[-1,"8am - 6pm\nExcept Sunday"],
	[-1,"7am - 7pm\nExcept Sunday"],
	[-1,"8am - 6pm\nAll Days"],
	[-1,"7am - 7pm\nAll Days"],
	[-1,"School Days\n7am - 4pm"],

	[0,"Monday - Friday\n10am - 4pm"],
	[1,"Monday - Friday\n7am - 10am\n4pm - 7pm"],

	[2,"8:30am - 7pm\nExcept Sunday",1],
	[2,"Monday - Friday\n6pm - Midnight\n\nSaturday\n8am - Midnight",6]
    ];

    var x = Math.floor(Math.random()*sin.length);
    data.value = sin[x][1];
    if(sin[x][0] == 2){
	hours.value = sin[x][2];
	type.value = 2;
    } else if(sin[x][0] == -1){
	type.value = Math.floor((Math.random()*2));
    }


    //type.value = Math.floor(Math.random()*2);
    //arrow.value = Math.floor((Math.random()*3));

    update();
}
init();
