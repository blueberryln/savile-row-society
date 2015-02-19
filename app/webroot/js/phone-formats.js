var n;
var p;
var p1;
function ValidateMobilePhone()
{
	p=p1.value	
	if(p.length==5)
	{	
		pp=p;			
		pp=pp+"-";
		document.getElementById('mobilePhone').value="";
		document.getElementById('mobilePhone').value=pp;			
	}
	setTimeout(ValidateMobilePhone,100)
}
function getMobilePhone(m)
{	
	n=m.name;	
	p1=m
	ValidateMobilePhone()
}


var k;
var u;
var u1;
function ValidateMobileHome()
{
	u=u1.value	
	if(u.length==3)
	{		
		pp=u;	
		pp=pp+"-";
		document.getElementById('mobileHome').value="";
		document.getElementById('mobileHome').value=pp;			
	}
	setTimeout(ValidateMobileHome,100)
}
function getMobileHome(m)
{	
	k=m.name;	
	u1=m
	ValidateMobileHome()
}


var l;
var v;
var v1;
function ValidateFax()
{
	v=v1.value	
	if(v.length==3)
	{		
		pp=v;	
		pp=pp+"-";
		document.getElementById('faxNumber').value="";
		document.getElementById('faxNumber').value=pp;			
	}
	setTimeout(ValidateFax,100)
}
function getFaxNumber(m)
{	
	l=m.name;	
	v1=m
	ValidateFax()
}



var r;
var s;
var s1;
function ValidateBusinessPhone(text)
{
	//alert(text);return false;
	s=s1.value
	if(s.length==3)
	{
		//d10=y.indexOf('(')		
		ss=s;
		z4=s.indexOf('(')
		z5=s.indexOf(')')
		if(z4==-1){
			ss="("+ss;
		}
		if(z5==-1){
			ss=ss+") ";
		}
		//yy="("+yy+")";

		if(isNaN(text))
		{
			if(text != "undefined")
			{
				document.getElementById(text).value="";
				document.getElementById(text).value=ss;
			}
		}
	}
	if(s.length>4)
	{
		z1=s.indexOf('(')
		z2=s.indexOf(')')		
		if (z2==-1)
		{
			l30=s.length;
			s30=s.substring(0,4);
			//alert(p30);
			s30=s30+")"
			s31=s.substring(4,l30);
			ss=s30+s31;
			//alert(y31);
			if(isNaN(text))
			{
				if(text != "undefined")
				{
					document.getElementById(text).value="";
					document.getElementById(text).value=ss;
				}
			}
		}
	}	
	if(s.length>5)
	{	
		s11=s.substring(z1+1,z2);	
		if(s11.length>3)
		{
			s12=s11;
			l12=s12.length+1;
			l15=s.length
			//l12=l12-3
			s13=s11.substring(0,3);
			s14=s11.substring(3,l12);	
			s15=s.substring(z2+1,l15);	
			ss="("+s13+")"+s14+s15;	
			if(isNaN(text))
			{
				if(text != "undefined")
				{
					document.getElementById(text).value="";
					document.getElementById(text).value=ss;
				}
			}
			//obj1.value="";
			//obj1.value=yy;
		}
		l16=s.length;
		s16=s.substring(z2+1,l16);	
		l17=s16.length;
		if(l17>3&&s16.indexOf('-')==-1)
		{
			s17=s.substring(z2+1,z2+5);
			s18=s.substring(z2+6,l16);
			s19=s.substring(0,z2+1);
			//alert(y19);
			ss=s19+s17+"-"+s18;
			if(isNaN(text))
			{
				if(text != "undefined")
				{
					document.getElementById(text).value="";
					document.getElementById(text).value=ss;
				}
			}
			//obj1.value="";
			//obj1.value=ss;
		}
	}

	setTimeout(ValidateBusinessPhone,100)
}
function getOther(h,text)
{
	//alert(text);return false;
	r=h.name;
	//y1=document.forms[0].elements[x]
	s1=h
	ValidateBusinessPhone(text)
}