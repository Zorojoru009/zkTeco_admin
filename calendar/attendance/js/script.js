// function for present
function goP(sid,d,m,y,t,dw)
{	
	var recslen =  document.forms[0].length;
	var checkboxes=""
	for(i=1;i<recslen;i++)
	{
		if(document.forms[0].elements[i].checked==true)
		checkboxes+= " " + document.forms[0].elements[i].name
	}
	
	if(checkboxes.length>0)
	{
		var con=confirm("Are you sure they are present?");
		if(con)
		{
			document.forms[0].action="present.php?recsno=" + checkboxes + "&sid=" + sid + "&day=" + d + "&month=" + m + "&year=" + y + "&type=" + t + "&dw=" + dw
			document.forms[0].submit()
		}
	}
	else
	{
		alert("No record is selected.")
	}
}
// function for absent
function goA(sid,d,m,y,t,dw)
{
	var recslen =  document.forms[0].length;
	var checkboxes=""
	for(i=1;i<recslen;i++)
	{
		if(document.forms[0].elements[i].checked==true)
		checkboxes+= " " + document.forms[0].elements[i].name
	}
	
	if(checkboxes.length>0)
	{
		var con=confirm("Are you sure they are absent?");
		if(con)
		{
			document.forms[0].action="absent.php?recsno=" + checkboxes + "&sid=" + sid +  "&day=" + d + "&month=" + m + "&year=" + y + "&type=" + t + "&dw=" + dw
			document.forms[0].submit()
		}
	}
	else
	{
		alert("No record is selected.")
	}
}

function selectall()
{
//		var formname=document.getElementById(formname);

		var recslen = document.forms[0].length;
		
		if(document.forms[0].topcheckbox.checked==true)
			{
				for(i=1;i<recslen;i++) {
				document.forms[0].elements[i].checked=true;
				}
	}
	else
	{
		for(i=1;i<recslen;i++)
		document.forms[0].elements[i].checked=false;
	}
}

function selectall2()
{
//		var formname=document.getElementById(formname);

		var recslen = document.forms[0].length;
		
		if(document.forms[0].topcheckbox2.checked==true)
			{
				for(i=1;i<recslen;i++) {
				document.forms[0].elements[i].checked=true;
				}
	}
	else
	{
		for(i=1;i<recslen;i++)
		document.forms[0].elements[i].checked=false;
	}
}