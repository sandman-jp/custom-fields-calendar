
//ページ全体

console.log('common')

const panels = ['schedule'];

for(let i=0; i<panels.length; i++){
	document.write('<script src="'+CFC_ASSETS_URL+'/admin/js/panels/'+panels[i]+'.js"></script>');
}