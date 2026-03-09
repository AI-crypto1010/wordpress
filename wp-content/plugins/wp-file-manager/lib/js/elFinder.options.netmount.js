/**
 * Default elFinder config of commandsOptions.netmount
 *
 * @type  Object
 */

elFinder.prototype._options.commandsOptions.netmount = {
	ftp: {
		name : 'FTP',
		inputs: {
			host     : jQuery('<input type="text"/>'),
			port     : jQuery('<input type="number" placeholder="21" class="elfinder-input-optional"/>'),
			path     : jQuery('<input type="text" value="/"/>'),
			user     : jQuery('<input type="text"/>'),
			pass     : jQuery('<input type="password" autocomplete="new-password"/>'),
			FTPS     : jQuery('<input type="checkbox" value="1" title="File Transfer Protocol over SSL/TLS"/>'),
			encoding : jQuery('<input type="text" placeholder="Optional" class="elfinder-input-optional"/>'),
			locale   : jQuery('<input type="text" placeholder="Optional" class="elfinder-input-optional"/>')
		}
	},
	dropbox2: elFinder.prototype.makeNetmountOptionOauth('dropbox2', 'Dropbox', 'Dropbox', {noOffline : true,
		root : '/',
		pathI18n : 'path',
		integrate : {
			title: 'Dropbox.com',
			link: 'https://www.dropbox.com'
		}
	}),
	googledrive: elFinder.prototype.makeNetmountOptionOauth('googledrive', 'Google Drive', 'Google', {
		integrate : {
			title: 'Google Drive',
			link: 'https://www.google.com/drive/'
		}
	}),
	onedrive: elFinder.prototype.makeNetmountOptionOauth('onedrive', 'One Drive', 'OneDrive', {
		integrate : {
			title: 'Microsoft OneDrive',
			link: 'https://onedrive.live.com'
		}
	}),
	box: elFinder.prototype.makeNetmountOptionOauth('box', 'Box', 'Box', {
		noOffline : true,
		integrate : {
			title: 'Box.com',
			link: 'https://www.box.com'
		}
	})
};
