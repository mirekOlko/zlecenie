function dataForJsObject(data){
	    var textInput = document.getElementById(data).value;
		var date=textInput.split(".");
		var dzien=parseInt(date[0]);
		var mies=parseInt(date[1]);
		var rok=parseInt(date[2]);
		var sdata=mies.toString()+'/'+dzien.toString()+'/'+rok.toString();
		return sdata;
	  }

function dataTest(){
	  
  if(document.getElementById("dataOd").value != '' && 
	 document.getElementById("dataDo").value != ''){
		var dataOd = new Date(dataForJsObject('dataOd'));
		var dataDo = new Date(dataForJsObject('dataDo'));
		if(dataOd>dataDo)
		{
			var test= document.getElementById("dataOd").value;
			document.getElementById("dataOd").value=document.getElementById("dataDo").value;
			document.getElementById("dataDo").value = test;
			}

  	}
  }

function datagora(){
	var ile_dni = parseInt(document.getElementById('ile_dni').value);

	var d = new Date(dataForJsObject('data_wystawienia'));
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());
    d.setTime(d.getTime() + ile_dni * 1000 * 60 * 60 * 24);
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());

	var dzien=d.getDate();
	if(d.getDate()<10)
		dzien='0'+d.getDate();
	var mies=d.getMonth()+1;
	if(d.getMonth()+1<10)
		mies='0'+mies.toString();
	var rok = d.getFullYear();
	
	var wynik = dzien.toString()+'.'+mies.toString()+'.'+rok.toString();
	document.getElementById("data_zaplaty_faktury").value = wynik;
	
}

function datadol(){
	var ile_dni = parseInt(document.getElementById('ile_dni').value);

	var d = new Date(dataForJsObject('data_zaplaty_faktury'));
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());
    d.setTime(d.getTime() - ile_dni * 1000 * 60 * 60 * 24);
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());

	var dzien=d.getDate();
	if(d.getDate()<10)
		dzien='0'+d.getDate();
	var mies=d.getMonth()+1;
	if(d.getMonth()+1<10)
		mies='0'+mies.toString();
	var rok = d.getFullYear();
	
	var wynik = dzien.toString()+'.'+mies.toString()+'.'+rok.toString();
	document.getElementById("data_wystawienia").value = wynik;
	
}

function formaPlatloscik(){
	if(document.getElementById("forma_platnosci1").selected==true)
		document.getElementById("zaplaconaTak").selected=true;
	if(document.getElementById("forma_platnosci4").selected==true)
		document.getElementById("zaplaconaTak").selected=true;
	if(document.getElementById("forma_platnosci2").selected==true)
		document.getElementById("zaplaconaNie").selected=true;
	if(document.getElementById("forma_platnosci3").selected==true)
		document.getElementById("zaplaconaNie").selected=true;
}

function usunFakture(dane, tresc)
{
	//alert("Hello! I am an alert box!!");
	//confirm('Czy Cchesz usunąć faktturę:'+tresc);
	if (confirm('Czy Cchesz usunąć faktturę:'+tresc)==true) {
		document.getElementById(dane).submit();
		}
	else
		{
		alert('zaniechano usuwanie');
		}
}

function teraz(wart)
{
	  
    var d = new Date();
    var dzien=d.getDate();
    if(d.getDate()<10)
        dzien='0'+d.getDate();
    var mies=d.getMonth()+1;
    if(d.getMonth()+1<10)
        mies='0'+mies.toString();
    var rok = d.getFullYear();
	  
    var wynik = dzien.toString()+'.'+mies.toString()+'.'+rok.toString();

    wart=wart.substr(0, wart.length - 1);
    document.getElementById(wart).value = wynik;
    wart=wart.substr(4, wart.length - 4);
    console.log(wart);
    document.getElementById(wart).checked = true;
}

function dataLeasing()
{
	var ile_dni = 14
	
	var d = new Date();
	d.setDate(1);
	//d.setMonth(11)
	var day=d.getDay();
	if(day==6)
	{
		d.setDate(3);
		//console.log(day);
	}
	if(day==0)
	{
		d.setDate(2);
		//console.log(day);
	}
	
	
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());
	//d.setTime(d.getTime() - ile_dni * 1000 * 60 * 60 * 24);
	//console.log(d.getDate()+' '+d.getMonth()+' '+d.getFullYear());
	//
	
	var dzien=d.getDate();
	if(d.getDate()<10)
		dzien='0'+d.getDate();
	var mies=d.getMonth()+1;
	if(d.getMonth()+1<10)
		mies='0'+mies.toString();
	var rok = d.getFullYear();
	
	var wynik = dzien.toString()+'.'+mies.toString()+'.'+rok.toString();
	document.getElementById("data_wystawienia").value = wynik;
	document.getElementById("ile_dni").value = 14;
	
	d.setTime(d.getTime()+14 * 1000 * 60 * 60 * 24)
	//console.log(d.setTime(d.getTime()+14 * 1000 * 60 * 60 * 24));
	
	dzien=d.getDate();
	if(d.getDate()<10)
		dzien='0'+d.getDate();
	wynik = dzien.toString()+'.'+mies.toString()+'.'+rok.toString();
	document.getElementById("data_zaplaty_faktury").value = wynik;
	
	
}