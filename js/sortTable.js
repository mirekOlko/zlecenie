//http://dev.cdur.pl/Artykuly/Sortowanie-tabeli-w-HTML-i-JavaScript-cz1
//http://dev.cdur.pl/Artykuly/Sortowanie-tabeli-w-HTML-i-JavaScript-cz2
//kod pobrany w całości ze strony
/*
 <table>
<tr><th class="ISort">Integer</th><th class="SSort">String</th><th class="SSort">Domyślne</th><th>Inne</th></tr>
<tr><td>2</td><td>A</td><td>2</td><td>Dodatkowe dane 1</td></tr>
<tr><td>10</td><td>B</td><td>10</td><td>Dodatkowe dane 2</td></tr>
<tr><td>3</td><td>G</td><td>3</td><td>Dodatkowe dane 3</td></tr>
<tr><td>111</td><td>D</td><td>111</td><td>Dodatkowe dane 4</td></tr>
</table> 
*/

		function Contains(classArray,value){
		  for (var i=0; i<classArray.length;i++)
		    if (classArray[i]===value) return true;
		  return false;
			}
		function IntegerSort(a,b){return parseInt(a)>parseInt(b);}
		function ValueSort(a,b){return a>b;}
		function attachSorting(){
		  var handlers=[['SSort', ValueSort],['ISort',IntegerSort]];
		  for(var i=0, ths=document.getElementsByTagName('th'); th=ths[i]; i++){
		    for (var h=0; h<handlers.length;h++) {
		      if(Contains(th.className.split(" "), handlers[h][0])){
		        th.columnIndex=i;
		        th.order=-1;
		        th.sortHandler = handlers[h][1];
		        th.onclick=function(){sort(this);}
		        var divNode = document.createElement('div');
		        var textNode = document.createTextNode('');
		        divNode.appendChild(textNode);
		        th.appendChild(divNode);
		        th.sortTextNode = textNode;
		      }
		    }
		  }
		}
		function SetOrder(th){
			  th.order *= -1;
			  th.sortTextNode.nodeValue=th.order<0?'\u25B2':'\u25BC';
			}
		function ResetOrder(th){
			  th.sortTextNode.nodeValue='';
			  th.order=-1;
			}
		function sort(header){
		    SetOrder(header);
		    var table = header.parentNode.parentNode;
		    for (var i=0, th, ths=table.getElementsByTagName('th'); th=ths[i]; i++)
		      if (th.order && th!=header)
		        ResetOrder(th);
		    var rows=table.getElementsByTagName('tr');
		    for(var i=1, tempRows=[], tr; tr=rows[i]; i++){tempRows[i-1]=tr}
		    tempRows.sort(function(a,b){
		      return header.order*
		        (header.sortHandler(
		          a.getElementsByTagName('td')[header.columnIndex].innerHTML,
		          b.getElementsByTagName('td')[header.columnIndex].innerHTML)?1:-1)});
		    for(var i=0; i<tempRows.length; i++){
		        table.appendChild(tempRows[i]);
		    }
		}