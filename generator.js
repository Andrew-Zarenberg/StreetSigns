
var img = document.getElementById("sign");
var link = document.getElementById("url");
var data = document.getElementById("data");
var line1 = document.getElementById("line1");
var line2 = document.getElementById("line2");
var type = document.getElementById("type");
var arrow = document.getElementById("arrow");
var hours = document.getElementById("hours");
var auth = document.getElementById("auth");
var night = document.getElementById("night");

var tr_metered = document.getElementById("tr_metered");
var tr_authorized = document.getElementById("tr_authorized");
var tr_night = document.getElementById("tr_night");

function update(){
    var d = data.value.replace(/\n/g,'`');

    if(type.value == 4){
	add = "|~"+auth.value.replace(/\n/g,"`|~");
	if(d) d = add+"``"+d;
	else d = add;
    }

    var url = "parking.php?type="+type.value+"&arrow="+arrow.value+"&data="+d
    if(type.value == 2 || type.value == 3) url += "&hours="+hours.value;
    if(night.checked) url += "&night=1";
    img.src = url;
    link.href = url;

    tr_metered.style.display = (type.value==2||type.value==3?"":"none");
    tr_authorized.style.display = (type.value==4?"":"none");
    tr_night.style.display = (type.value==5?"":"none");
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
	[2,"Monday - Friday\n6pm - Midnight\n\nSaturday\n8am - Midnight",6],
	[2,"Monday - Friday\n10am - 7pm\n\nSaturday\n9am - 7pm",1],

	[3,"Monday - Friday\n7am - 7pm",3],
	[3,"Monday - Friday\n7am - 6pm",3],
	[3,"Monday - Friday\n8am - 6pm",3],
	[3,"7am - 7pm\nExcept Sunday",3],
	[3,"8am - 6pm\nExcept Sunday",3],

	[4,"School Days\n7am - 4pm","Dept of\nEducation"],
	[4,"Monday - Friday\n7am - 7pm","Administration\nfor Children's\nServices"],
	[4,"7am - 7pm\nAll Days","Medical\nExaminer's\nOffice"],

	[5,"Monday\nThursday\n\n9am - 10:30am"],
	[5,"Tuesday\nFriday\n\n9am - 10:30am"],
	[5,"8am - 8:30am\nExcept Sunday"]
    ];

    var x = Math.floor(Math.random()*sin.length);
    data.value = sin[x][1];
    if(sin[x][0] == 2 || sin[x][0] == 3) hours.value = sin[x][2];
    else if(sin[x][0] == 4) auth.value = sin[x][2];
    //if(sin[x].length == 3) hours.value = sin[x][2];

    if(sin[x][0] == -1) type.value = Math.floor((Math.random()*2));
    else type.value = sin[x][0];

    update();
}
init();
