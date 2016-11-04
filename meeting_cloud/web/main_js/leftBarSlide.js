/**
 * @author Neal
 */
$(document).ready(function()
{
	$("#HEADER").click(function()
	{
		 window.location.assign("main.php");
	});
});

$(document).ready(function()
{
		$("#member_Bar").mouseover(function() 
		{
			$("#member_Bar").css("background-color","#00AA55");
		});
		
		$("#member_Bar").mouseout(function() 
		{
			$("#member_Bar").css("background-color","#00AA55");
		});
});

$(document).ready(function()
{
	  $("#meeting_Bar").mouseover(function() 
	  {
		  $("#meeting_Bar").css("background-color","#00AA55");
	  });
	  
	  $("#meeting_Bar").mouseout(function() 
	  {
		  $("#meeting_Bar").css("background-color","#00AA55");
	  });
});

function addNewConvertionReport(obj)
{
    var num = obj.parentNode.parentNode.rowIndex + 1;
    var Tr = document.getElementById("dynamicReportTable").insertRow(num);
    var index = Tr.rowIndex/2 + 1;
    
    Td = Tr.insertCell(Tr.cells.length);
    Td.innerHTML = '<table id="table"><tr><td id="tableTittle1">項次</td><td id="tableValue1"><input id="tableValue1" type="text" name="ConventionReportNum[]" readonly/></td></tr><tr><td id="tableTittle2">內容</td><td id="tableValue2"><textarea id="tableValue2" name="ConventionReportContent[]" rows="5"></textarea></td></tr></table>';
	
	var num = num + 1;
    var Tr = document.getElementById("dynamicReportTable").insertRow(num);
    Td = Tr.insertCell(Tr.cells.length);
    Td.innerHTML = '<input id="tableButtonAdd" type="button" onclick="addNewConvertionReport(this)" value="新增報告事項"/><input id="tableButtonDelete" type="button" onclick="deleteConvertionReport(this)" value="刪除報告事項"/>';
}

function deleteConvertionReport(obj)
{
	var rowNum = document.getElementById("dynamicReportTable").rows.length;
	
	if(rowNum > 2)
	{
		var num = obj.parentNode.parentNode.rowIndex - 1;
	    var Tr = document.getElementById("dynamicReportTable");
	    Tr .deleteRow(num);
	    Tr .deleteRow(num);
    }
}

function addNewConvertionDiscuss(obj)
{
    var num = obj.parentNode.parentNode.rowIndex + 1;
    var Tr = document.getElementById("dynamicDiscussTable").insertRow(num);
    //var index = Tr.rowIndex/2 + 1;
    
    Td = Tr.insertCell(Tr.cells.length);
    Td.innerHTML = '<table id="table"><tr><td id="tableTittle1">項次</td><td id="tableValue1"><input id="tableValue1" type="text" name="ConventionDiscussNum[]" readonly/></td></tr><tr><td id="tableTittle2">案由</td><td id="tableValue2"><input id="tableValue2" type="text" name="ConventionDiscussReason[]"/></td></tr><tr><td id="tableTittle1">說明</td><td id="tableValue1"><textarea id="tableValue1" name="ConventionDiscussExplain[]" rows="5"></textarea></td></tr><tr><td id="tableTittle2">決議</td><td id="tableValue2"><textarea id="tableValue2" name="ConventionDiscussResolution[]" rows="5"></textarea></td></tr><tr><td id="tableTittle1">類型</td><td id="tableValue1"><select name="conType[]"><option value="1">一般討論</option><option value="2">臨時動議</option></select></td></tr></table>';
	
	var num = num + 1;
    var Tr = document.getElementById("dynamicDiscussTable").insertRow(num);
    Td = Tr.insertCell(Tr.cells.length);
    Td.innerHTML = '<input id="tableButtonAdd" type="button" onclick="addNewConvertionDiscuss(this)" name="send" value="新增討論事項"/><input id="tableButtonDelete" type="button" onclick="deleteConvertionDiscuss(this)" name="send" value="刪除報告事項"/>';
}

function deleteConvertionDiscuss(obj)
{
	var rowNum = document.getElementById("dynamicDiscussTable").rows.length;
	
	if(rowNum > 2)
	{
		var num = obj.parentNode.parentNode.rowIndex - 1;
	    var Tr = document.getElementById("dynamicDiscussTable");
	    Tr .deleteRow(num);
	    Tr .deleteRow(num);
    }
    
    /*var rowLenght = document.getElementById("dynamicDiscussTable").rows.lenght;
    
    for(var i = 0;i < rowLenght; i++)
    {
    	if(i%2 == 0)
    	{
		    var table = document.getElementById("dynamicDiscussTable").getElementById("table");
		    var index = Tr.rowIndex/2 + 1;
		    
		    table(i).getElementById("dynamicDiscussTableValue").innerHTML = '<input id="tableValue1" type="text" name="ConventionDiscussNum[]" value = "' + index + '"/>';
		}
    }*/
}