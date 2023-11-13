<?php

namespace App\Utilities\Helpers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Dto\Email;
use Elasticsearch;

class ElasticsearchHelper implements ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param Email $email
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(Email $email): mixed {
        $data = [
            'body' => [
                'email' => $email->email,
                'subject' => $email->subject,
                'body' => $email->body,
            ],
            'index' => 'sent-emails',
        ];

        $result = Elasticsearch::index($data);

        return $result['_id'];
    }
}
