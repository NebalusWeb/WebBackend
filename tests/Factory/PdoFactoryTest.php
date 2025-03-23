<?php

namespace Factory;

use Nebalus\Webapi\Factory\PdoFactory;
use Nebalus\Webapi\Config\GeneralConfig;
use Nebalus\Webapi\Config\MySqlConfig;
use PDO;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PdoFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanCreatePdoInstance(): void
    {
        $envData = new MySqlConfig();
        $envMock = $this->createMock(MySqlConfig::class);

        $envMock->expects($this->once())
            ->method('getMySqlHost')
            ->with()
            ->willReturn($envData->getMySqlHost());
        $envMock->expects($this->once())
            ->method('getMySqlPort')
            ->with()
            ->willReturn($envData->getMySqlPort());
        $envMock->expects($this->once())
            ->method('getMySqlDatabase')
            ->with()
            ->willReturn($envData->getMySqlDatabase());
        $envMock->expects($this->once())
            ->method('getMySqlUser')
            ->with()
            ->willReturn($envData->getMySqlUser());
        $envMock->expects($this->once())
            ->method('getMySqlPasswd')
            ->with()
            ->willReturn($envData->getMySqlPasswd());

        $pdoFactory = new PdoFactory($envMock);
        $pdo = $pdoFactory();

        $this->assertSame(PDO::ERRMODE_EXCEPTION, $pdo->getAttribute(PDO::ATTR_ERRMODE));
        $this->assertSame(PDO::FETCH_ASSOC, $pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE));
        $this->assertFalse($pdo->getAttribute(PDO::ATTR_STRINGIFY_FETCHES));
    }
}
