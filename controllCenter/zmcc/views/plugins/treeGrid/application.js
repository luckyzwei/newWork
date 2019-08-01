window.onload = function() {
	var config = {
		id: "tg1",
		renderTo: "categoryList",
		indentation: "20",
		folderOpenIcon: "../plugins/treeGrid/images/folderOpen.png",
		folderCloseIcon: "../plugins/treeGrid/images/folderClose.png",
		defaultLeafIcon: "../plugins/treeGrid/images/defaultLeaf.gif",
		hoverRowBackground: "false",
		folderColumnIndex: "1",
		columns: [
			{
			headerText: "",
			headerAlign: "left",
			dataAlign: "left",
		},
			{
				headerText: "名称",
				dataField: "name",
                headerAlign: "left",
                dataAlign: "left",
				handler: "customOrgName"
			},

		{
			headerText: "图片",
			dataField: "images",
			headerAlign: "center",
			dataAlign: "center",
            handler: "customOrgImg",
		},
		{
			headerText: "操作",
            dataField: "edit",
			headerAlign: "center",
			dataAlign: "center",
			handler: "customOption"
		}],
		data: [
		{
			name: "蔬果",
			id: "1",
			images: "../dist/img/avatar.png",
			edit:'商品分类编辑.html',
			children: [{
				name: "蔬菜",
                images: "../dist/img/avatar.png",
			},
			{
				name: "水果",
				children: [{
					name: "苹果"
				},
				{
					name: "梨子"
				},
				{
					name: "橘子",
					children: [{
						name: "chlid3-1"
					},
					{
						name: "chlid3-2"
					},
					{
						name: "chlid3-3"
					},
					{
						name: "chlid3-4"
					}]
				}]
			}]
		},
		{
			name: "海鲜",
			id: "2",
			assignee: "",
			children: []
		},
		{
			name: "酒水",
			id: "3",
			assignee: "",
			children: []
		},
		{
			name: "饮料",
			id: "4",
			assignee: "",
			children: []
		}]
	};
	// debugger;
	var treeGrid = new TreeGrid(config);
	treeGrid.show()
    treeGrid.expandAll('N')
}
