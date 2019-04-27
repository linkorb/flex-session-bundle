# FlexSessionBundle
FlexSession: Symfony bundle

FlexSessionBundle provider integration [FlexSession](https://github.com/linkorb/flex-session) library to symfony framework.

### Configuration

1. Enable the ```FlexSessionBundle\FlexSessionBundle``` bundle in the kernel
2. Replace your session handler to ```FlexSessionHandler```

```yaml
framework:
    session:
        handler_id: FlexSession\FlexSessionHandler
```