<?php

namespace App\Utilities\Helpers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Dto\Email;
use Elasticsearch;
use Illuminate\Support\Collection;

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

    public function getSentEmails(): Collection {
        $data = [
            'index' => 'sent-emails',
            'body'  => [
                'query' => [
                    'match_all' => (object)[],
                ],
            ],
        ];

        $result = Elasticsearch::search($data);

        return collect($result['hits']['hits'])->map(fn($hit) => $hit['_source']);
    }
}
