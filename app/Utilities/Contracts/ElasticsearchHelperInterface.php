<?php

namespace App\Utilities\Contracts;

use App\Utilities\Dto\Email;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param Email $email
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(Email $email): mixed;
}
