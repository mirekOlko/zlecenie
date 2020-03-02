function datagora(){
	var ile_dni = parseInt(document.getElementById('ile_dni').value);
    var textInput = document.getElementById('data_wystawienia').value;

	var date=textInput.split(".");
	
//	  var str = "12.15.1521";
    //var res = str.split(".");
	var dzien=parseInt(date[0]);
	var mies=parseInt(date[1]);
	var rok=parseInt(date[2]);
	var sdata=mies.toString()+'/'+dzien.toString()+'/'+rok.toString();
	var d = new Date(sdata);
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
    var textInput = document.getElementById('data_zaplaty_faktury').value;

	var date=textInput.split(".");
	
//	  var str = "12.15.1521";
    //var res = str.split(".");
	var dzien=parseInt(date[0]);
	var mies=parseInt(date[1]);
	var rok=parseInt(date[2]);
	var sdata=mies.toString()+'/'+dzien.toString()+'/'+rok.toString();
	var d = new Date(sdata);
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
