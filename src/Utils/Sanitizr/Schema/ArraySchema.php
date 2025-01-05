<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

class ArraySchema extends AbstractSchema
{
    public function __construct(
        private readonly AbstractSchema $schema
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
