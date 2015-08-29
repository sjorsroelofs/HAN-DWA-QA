jQuery(function($) {

    'use strict';

    var $newQuestionForm = $('#han_dwa_qa_new_question_form_wrapper form');

    if($newQuestionForm.length) {
        $newQuestionForm.on('submit', function(event) {
            event.preventDefault();

            var data = {
                'action': 'han_dwa_qa_ajax_new_question',
                'qa_id': $newQuestionForm.data('qa-id'),
                'name': $newQuestionForm.find('input[name=name]').val(),
                'email': $newQuestionForm.find('input[name=email]').val(),
                'question': $newQuestionForm.find('textarea[name=question]').val(),
                'reference': $newQuestionForm.find('textarea[name=reference]').val()
            };

            $.post(han_dwa_qa_ajax_object.ajax_url, data, function(response) {
                var response = $.parseJSON(response);

                if(response.error === false) {
                    location.reload();
                } else {
                    alert('Oops.. Er ging iets fout bij het plaatsen van je vraag. Controleer of alle velden correct zijn ingevuld en probeer het nogmaals.');
                }
            });
        });
    }

    $.each($('.han_dwa_qa_asked_question .upvote'), function() {
        var $this = $(this);

        $this.on('click', function() {
            var data = {
                'action': 'han_dwa_qa_ajax_upvote_question',
                'question_id': $this.data('question-id')
            };

            $.post(han_dwa_qa_ajax_object.ajax_url, data, function(response) {
                var response = $.parseJSON(response);

                if(response.error === false) {
                    location.reload();
                } else {
                    alert('Oops.. Er ging iets fout bij het upvoten van deze vraag. Je kunt een vraag slechts eenmaal upvoten.');
                }
            });
        });
    });

});