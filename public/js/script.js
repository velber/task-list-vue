app = function () {

    this.allowedTaskLength = 128;

    this.allowedTasks = 20;

    this.showSnackBar = function (message) {
        document.querySelector('#demo-toast-example')
            .MaterialSnackbar
            .showSnackbar({
                message: message,
                timeout: 1500
            });
    };

    this.showSpinner = function () {
        $('.mdl-spinner.is-upgraded').addClass('is-active').show();
        $('body').append('<div class="spinner-wrap"></div>')
    };

    this.hideSpinner = function () {
        $('.mdl-spinner.is-upgraded').removeClass('is-active');
        $('.spinner-wrap').remove();
    };

    this.parseResponse = function(response) {
        for (var a in response) {
            return response[a][0];
        }
    };
};

tasksController = function () {

    app.call(this);

    var self = this;

    this.init = function () {
        this.token = $('.container .form-group__task').data('token');

        this.table = $('.mdl-data-table');

        this.taskName= $('#name');

        this.taskStatus = $('#status_id');

        // add new task
        $('.form-group__task #submit-task').on('click', function () {

            // validate fields
            if (0 == self.taskName.val().length) {
                self.showSnackBar('Task can`t be empty!');
                return false;
            }

            if (self.taskName.val().length > self.allowedTaskLength) {
                self.showSnackBar(`Sorry, allowed task length is ${self.allowedTaskLength} chars!`);
                return false;
            }

            if (! self.taskStatus.val()) {
                self.showSnackBar('Please, select task status!');
                return false;
            }

            // check max allowed tasks
            if ($('.mdl-data-table tr').length >= self.allowedTasks) {
                self.showSnackBar(`Sorry, only ${self.allowedTasks} tasks are allowed!`);
                return false;
            }

            self.store();
        });

        // on delete
        this.table.on('click', '.mdl-button__delete', function () {
            self.delete(this);
        });

        // on start editing task
        this.table.on('focus', '.task-edit', function () {
            $('.save-task .mdl-button').hide();
            $('.task-edit').each(function () {
                $(this).removeClass('editable');
            });
            $(this).addClass('editable');
            $(this).closest('tr').find('.save-task .mdl-button').show();
        });

        // on save changes
        this.table.on('click', '.save-task .mdl-button', function () {
            let $taskField = $(this).closest('tr').find('.task-edit');
            if (0 == $taskField.text().length) {
                self.showSnackBar('Task can`t be empty!');
                return false;
            }

            if ($taskField.text().length > self.allowedTaskLength) {
                self.showSnackBar(`Sorry, allowed task length is ${self.allowedTaskLength} chars!`);
                return false;
            }

            $taskField.removeClass('editable');

            self.update(this, $(this).data('action'), $taskField.text());
            $(this).hide();
        });

        // on change tasks status
        this.table.on('change', '#status_id', function () {
            self.update(this, $(this).data('action'), $(this).val());
        });
    };

    this.store = function () {
        self.showSpinner();
        $.ajax({
            type: 'post',
            url: '/task',
            data: {
                _token: self.token,
                name: self.taskName.val(),
                status_id: self.taskStatus.val()
            }
        })
            .always(function (data) {
                self.hideSpinner();
                let message;

                if (1 == data.success) {
                    message = 'Task added!';
                    self.table.find('tbody').prepend(data.task);
                } else {
                    message = self.parseResponse(data.responseJSON);
                }

                self.showSnackBar(message);
                self.taskName.val('');
            });
    };

    this.update = function (el, action, value) {
        self.showSpinner();
        var data = {
            _token: self.token,
            _method: 'patch'
        };

        data[action] = value;
        var $tr = $(el).closest('tr');

        $.ajax({
            type: 'post',
            url: '/task/' + $tr.data('id'),
            data: data
        })
            .always(function (data) {
                self.hideSpinner();
                self.showSnackBar(1 == data.success ? 'Task updated!' : self.parseResponse(data.responseJSON));
            });
    };

    this.delete = function (el) {
        self.showSpinner();
        var $tr = $(el).closest('tr');
        $.ajax({
            type: 'post',
            url: '/task/' + $tr.data('id'),
            data: {
                _token: self.token,
                _method: 'delete'
            }
        })
            .always(function (data) {
                self.hideSpinner();
                var message;

                if (1 == data.success) {
                    message = 'Task deleted!';
                    $tr.remove();
                } else {
                    message = 'Error!';
                }

                self.showSnackBar(message);
            });
    };

};

var task = new tasksController();

$(document).ready(function () {
    task.init();

    // event change order by drag and drop
    $( '#sortable' ).sortable({
        handle: '.material-icons__move',
        stop: function (e, ui) {
            let topOrder = $(ui.item).prev().data('order');
            let bottomOrder = $(ui.item).next().data('order');
            let newOrder;

            if (undefined === topOrder) {
                newOrder = bottomOrder + 1;
            } else if (undefined === bottomOrder) {
                newOrder = topOrder - 1;
            } else {
                newOrder = (bottomOrder + topOrder) / 2;
            }

            task.update(ui.item, 'order', newOrder);
        }
    });
});
