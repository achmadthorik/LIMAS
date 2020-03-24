//===================================\\
//           Copyright 2017          \\
//        Aditya Khoirul Anam        \\
//           LIMAS Project           \\
//===================================\\
/*
$(document).ready(function() {
  if ($(this).find("tbody").attr("XA-table")) {
    var id;
    if (!id) {
        id = "";
    }
    var key = "";
    var query = {"action" : "populatetable", "search" : id, "key" : key};
    XAVIER({"processor" : "members", "data" : query}, function(data, status) {
        var items = [];
        if(data) {
            var xjson = $.parseJSON(data);
        }
        $.each(xjson, function(index, value) {
            items.push("<tr>");
            items.push(
                "<td><input type='checkbox' class='cbSingle' id='" +
                index + "' value='" + value[0] + "'></td>"
            );
            items.push("<td>" + value[0] + "</td>");
            items.push("<td>" + value[1] + "</td>");
            items.push("<td>" + value[2] + "</td>");
            items.push("<td>" + value[3] + "</td>");
            items.push(
                "<td>" +
                "<a href='#Edit' onclick=\"EditMember('" + value[0] +
                "')\"><?=MEMBERS['table']['edit']?></a>&nbsp;" +
                "<a href='#Delete' onclick=\"DeleteMember('" + value[0] +
                "','" + value[1] + "')\"><?=MEMBERS['table']['delete']?></a>"
            );
        });
        var output = items.join("");
        var xam = $(this).attr("XA-table");
        //$("tbody").html(output);
        //$(this).html(output);
        xam.html(output);
        console.log(data);
    });
  }
});
*/
