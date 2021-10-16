import axios from 'axios';

export default {
    getData(pathToList, id) {
        return axios.get('/api/filemanager/data', {
            params: {folder: pathToList, userId: id }
        }).then(response => response.data);
    },
    createFolder(folderName, currentFolder, id) {
        return axios.post('/api/filemanager/actions/create-folder', {
            folder: folderName,
            current: currentFolder,
            userId: id
        }).then(response => response.data);
    },
    removeDirectory(currentFolder, id) {
        return axios.post('/api/filemanager/actions/delete-folder', {
            current: currentFolder,
            userId: id
        }).then(response => response.data);
    },
    getInfo(file, id) {
        return axios.post('/api/filemanager/actions/get-info', {
            file: file,
            userId: id
        }).then(response => response.data);
    },
    removeFile(file, id) {
        return axios.post('/api/filemanager/actions/remove-file', {
            file: file,
            userId: id
        }).then(response => response.data);
    },
    renameFile(file, name, id) {
        return axios.post('/api/filemanager/actions/rename-file', {
            file: file,
            name: name,
            userId: id
        }).then(response => response.data);
    },

    rename(path, name, id) {
        return axios.post('/api/filemanager/actions/rename', {
            path: path,
            name: name,
            userId: id
        }).then(response => response.data);
    }
};
