<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

class SanitizerArraySchema extends AbstractSanitizerSchema
{
    public function __construct(
        private readonly AbstractSanitizerSchema $schema
    ) {
    }

    protected function parseValue(mixed $value): array
    {
//        if (! is_array( $value ) ) {
//            throw new \Exception( 'Not an array' );
//        }
//        $result = array();
//        foreach ( $value as $v ) {
//            $result[] = $this->schema->parse( $v );
//        }
//
        return $value;
    }
}
